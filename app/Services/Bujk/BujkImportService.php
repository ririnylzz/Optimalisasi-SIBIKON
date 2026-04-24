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
        protected SimpleSpreadsheetReader $reader,
        protected BujkDataNormalizer $normalizer,
    ) {
    }

    public function import(UploadedFile $file): array
    {
        $rows = $this->reader->read(
            $file->getRealPath(),
            $file->getClientOriginalName()
        );

        if (empty($rows)) {
            throw ValidationException::withMessages([
                'file_import' => 'Header file tidak dikenali atau file tidak memiliki data yang bisa diimport.',
            ]);
        }

        $summary = [
            'filename' => $file->getClientOriginalName(),
            'total_rows' => 0,
            'prepared_rows' => 0,
            'created' => 0,
            'updated' => 0,
            'merged_rows' => 0,
            'skipped' => 0,
            'errors' => [],
        ];

        $preparedRows = [];

        foreach ($rows as $row) {
            $summary['total_rows']++;

            $normalized = $this->normalizer->normalizeImportRow($row);

            if ($normalized === null) {
                $summary['skipped']++;
                $summary['errors'][] = 'Baris ' . ($row['__row_number'] ?? $summary['total_rows']) . ': NIB kosong atau tidak valid.';
                continue;
            }

            $validator = Validator::make(
                $normalized,
                $this->rules(),
                [],
                $this->attributes()
            );

            if ($validator->fails()) {
                $summary['skipped']++;

                foreach ($validator->errors()->all() as $error) {
                    $summary['errors'][] = 'Baris ' . ($row['__row_number'] ?? $summary['total_rows']) . ': ' . $error;
                }

                continue;
            }

            $nib = $normalized['nib'];

            if (isset($preparedRows[$nib])) {
                $preparedRows[$nib] = $this->normalizer->mergeDuplicateImportRows($preparedRows[$nib], $normalized);
                $summary['merged_rows']++;
            } else {
                $preparedRows[$nib] = $normalized;
            }
        }

        $summary['prepared_rows'] = count($preparedRows);
        $summary['errors'] = array_slice(array_values(array_unique($summary['errors'])), 0, 15);

        if (empty($preparedRows)) {
            throw ValidationException::withMessages([
                'file_import' => 'Tidak ada data valid yang bisa diimport.',
            ]);
        }

        DB::transaction(function () use (&$summary, $preparedRows) {
            foreach ($preparedRows as $prepared) {
                $existing = Bujk::query()
                    ->where('nib', $prepared['nib'])
                    ->first();

                if ($existing) {
                    $payload = $this->normalizer->mergeImportedWithExisting($existing, $prepared);

                    $existing->fill($payload);
                    $existing->is_deleted = false;
                    $existing->save();

                    $summary['updated']++;
                } else {
                    Bujk::query()->create($prepared + [
                        'is_deleted' => false,
                    ]);

                    $summary['created']++;
                }
            }
        });

        return $summary;
    }

    protected function rules(): array
    {
        return [
            'nib' => ['required', 'string', 'max:50'],
            'nama_bujk' => ['required', 'string', 'max:255'],
            'jenis_bujk' => ['required', 'string', 'max:255'],
            'alamat_bujk' => ['nullable', 'string', 'max:1000'],
            'provinsi_bujk' => ['nullable', 'string', 'max:255'],
            'kab_kota_bujk' => ['nullable', 'string', 'max:255'],
            'npwp_bujk' => ['nullable', 'string', 'max:50'],
            'email_bujk' => ['nullable', 'email', 'max:255'],
            'telp_bujk' => ['nullable', 'string', 'max:50'],
            'website_bujk' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function attributes(): array
    {
        return [
            'nib' => 'NIB',
            'nama_bujk' => 'nama BUJK',
            'jenis_bujk' => 'jenis usaha',
            'alamat_bujk' => 'alamat',
            'provinsi_bujk' => 'provinsi',
            'kab_kota_bujk' => 'kabupaten / kota',
            'npwp_bujk' => 'NPWP',
            'email_bujk' => 'email',
            'telp_bujk' => 'nomor telepon',
            'website_bujk' => 'website',
        ];
    }
}