<?php

namespace App\Services\Bujk;

use App\Models\Bujk;
use App\Support\BujkDataNormalizer;
use App\Support\SimpleSpreadsheetReader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BujkImportService
{
    public function __construct(
        protected SimpleSpreadsheetReader $spreadsheetReader,
        protected BujkDataNormalizer $normalizer,
    ) {
    }

    public function import(UploadedFile $file): array
    {
        $rawRows = $this->spreadsheetReader->read($file->getRealPath(), $file->getClientOriginalName());

        if (empty($rawRows)) {
            throw ValidationException::withMessages([
                'file_import' => 'Header file tidak dikenali atau file tidak memiliki data yang bisa diimport.',
            ]);
        }

        $preparedRows = [];
        $errors = [];
        $mergedRows = 0;

        foreach ($rawRows as $row) {
            $rowNumber = $row['__row_number'] ?? null;
            $record = $this->normalizer->normalizeImportedRow($row);
            $validator = Validator::make($record, [
                'nib' => ['required', 'string', 'max:50'],
                'nama_bujk' => ['required', 'string', 'max:255'],
                'npwp_bujk' => ['nullable', 'string', 'max:50'],
                'jenis_bujk' => ['required', 'string', 'max:100'],
                'alamat_bujk' => ['nullable', 'string'],
                'kab_kota_bujk' => ['nullable', 'string', 'max:255'],
                'provinsi_bujk' => ['nullable', 'string', 'max:255'],
                'telp_bujk' => ['nullable', 'string', 'max:50'],
                'email_bujk' => ['nullable', 'email:rfc', 'max:255'],
                'website_bujk' => ['nullable', 'string', 'max:255'],
                'jumlah_tenaga_kerja' => ['nullable', 'integer', 'min:0'],
            ], [], [
                'nib' => 'NIB',
                'nama_bujk' => 'nama BUJK',
                'jenis_bujk' => 'jenis usaha',
                'email_bujk' => 'email',
            ]);

            if ($validator->fails()) {
                $prefix = $rowNumber ? 'Baris ' . $rowNumber . ': ' : '';
                $errors[] = $prefix . $validator->errors()->first();
                continue;
            }

            $signature = $this->makeSignature($record);

            if (isset($preparedRows[$signature])) {
                $preparedRows[$signature] = $this->mergeRows($preparedRows[$signature], $record);
                $mergedRows++;
                continue;
            }

            $preparedRows[$signature] = $record;
        }

        if (empty($preparedRows)) {
            throw ValidationException::withMessages([
                'file_import' => 'Tidak ada data valid yang bisa diimport ke tabel BUJK.',
            ]);
        }

        $created = 0;
        $updated = 0;
        $untouched = 0;

        DB::transaction(function () use (&$created, &$updated, &$untouched, $preparedRows): void {
            foreach ($preparedRows as $record) {
                $existing = Bujk::query()->where('nib', $record['nib'])->first();

                if (!$existing && !blank($record['npwp_bujk'])) {
                    $existing = Bujk::query()
                        ->where('npwp_bujk', $record['npwp_bujk'])
                        ->where('nama_bujk', $record['nama_bujk'])
                        ->first();
                }

                if ($existing) {
                    $existing->fill($this->mergeRows($existing->toArray(), $record));
                    $existing->is_deleted = false;

                    if ($existing->isDirty()) {
                        $existing->save();
                        $updated++;
                    } else {
                        $untouched++;
                    }

                    continue;
                }

                Bujk::query()->create($record + ['is_deleted' => false]);
                $created++;
            }
        });

        return [
            'filename' => $file->getClientOriginalName(),
            'total_rows' => count($rawRows),
            'prepared_rows' => count($preparedRows),
            'created' => $created,
            'updated' => $updated,
            'untouched' => $untouched,
            'merged_rows' => $mergedRows,
            'skipped' => count($errors),
            'errors' => array_slice($errors, 0, 10),
        ];
    }

    protected function makeSignature(array $record): string
    {
        if (!blank($record['nib'] ?? null)) {
            return 'nib:' . $record['nib'];
        }

        return 'fallback:' . strtolower(($record['npwp_bujk'] ?? '-') . '|' . ($record['nama_bujk'] ?? '-'));
    }

    protected function mergeRows(array $base, array $incoming): array
    {
        $mergedJenis = $this->normalizer->normalizeJenisBujk([
            ...$this->normalizer->normalizeJenisBujk($base['jenis_bujk'] ?? null),
            ...$this->normalizer->normalizeJenisBujk($incoming['jenis_bujk'] ?? null),
        ]);

        return [
            'nib' => $this->preferValue($base['nib'] ?? null, $incoming['nib'] ?? null),
            'nama_bujk' => $this->preferLongerValue($base['nama_bujk'] ?? null, $incoming['nama_bujk'] ?? null),
            'npwp_bujk' => $this->preferValue($base['npwp_bujk'] ?? null, $incoming['npwp_bujk'] ?? null),
            'jenis_bujk' => empty($mergedJenis)
                ? $this->preferValue($base['jenis_bujk'] ?? null, $incoming['jenis_bujk'] ?? null)
                : implode(', ', $mergedJenis),
            'alamat_bujk' => $this->preferLongerValue($base['alamat_bujk'] ?? null, $incoming['alamat_bujk'] ?? null),
            'kab_kota_bujk' => $this->preferValue($base['kab_kota_bujk'] ?? null, $incoming['kab_kota_bujk'] ?? null),
            'provinsi_bujk' => $this->preferValue($base['provinsi_bujk'] ?? null, $incoming['provinsi_bujk'] ?? null),
            'telp_bujk' => $this->preferValue($base['telp_bujk'] ?? null, $incoming['telp_bujk'] ?? null),
            'email_bujk' => $this->preferValue($base['email_bujk'] ?? null, $incoming['email_bujk'] ?? null),
            'website_bujk' => $this->preferValue($base['website_bujk'] ?? null, $incoming['website_bujk'] ?? null),
            'jumlah_tenaga_kerja' => $base['jumlah_tenaga_kerja'] ?? $incoming['jumlah_tenaga_kerja'] ?? null,
        ];
    }

    protected function preferValue(mixed $base, mixed $incoming): mixed
    {
        if (blank($base) && !blank($incoming)) {
            return $incoming;
        }

        return $base;
    }

    protected function preferLongerValue(?string $base, ?string $incoming): ?string
    {
        if (blank($base)) {
            return $incoming;
        }

        if (blank($incoming)) {
            return $base;
        }

        return strlen($incoming) > strlen($base) ? $incoming : $base;
    }
}