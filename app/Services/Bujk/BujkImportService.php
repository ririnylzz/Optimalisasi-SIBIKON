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

            $validator = Validator::make($record, $this->rules(), [], $this->attributes());

            if ($validator->fails()) {
                $prefix = $rowNumber ? 'Baris ' . $rowNumber . ': ' : '';
                $errors[] = $prefix . $validator->errors()->first();
                continue;
            }

            $signature = $this->makeSignature($record);

            if (isset($preparedRows[$signature])) {
                /*
                 * File upload jadi sumber utama.
                 * Kalau ada baris duplikat dalam file yang sama, pakai baris terbaru,
                 * bukan merge dengan nilai lama.
                 */
                $preparedRows[$signature] = $record;
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
                $existing = $this->findExistingRecord($record);

                if ($existing) {
                    /*
                     * File upload adalah patokan utama.
                     * Jadi kalau email/website/field lain kosong di file upload,
                     * maka database juga ikut kosong.
                     */
                    $existing->fill($record);
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

    protected function rules(): array
    {
        return [
            'id_izin' => ['nullable', 'string', 'max:255'],
            'nib' => ['required', 'string', 'max:50'],
            'npwp' => ['nullable', 'string', 'max:50'],
            'asosiasi' => ['nullable', 'string', 'max:255'],
            'nama_bu' => ['required', 'string', 'max:255'],
            'bentuk_usaha' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email:rfc', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'faksimili' => ['nullable', 'string', 'max:50'],
            'propinsi' => ['nullable', 'string', 'max:255'],
            'kabupaten' => ['nullable', 'string', 'max:255'],
            'jenis_usaha' => ['required', 'string', 'max:255'],
            'sifat' => ['nullable', 'string', 'max:255'],
            'kbli_bener' => ['nullable', 'string', 'max:50'],
            'kbli_inputan' => ['nullable', 'string', 'max:50'],
            'ket_kbli' => ['nullable', 'string'],
            'bentuk_badan_usaha' => ['nullable', 'string', 'max:255'],
            'klasifikasi' => ['nullable', 'string', 'max:255'],
            'kode_subklasifikasi' => ['nullable', 'string', 'max:50'],
            'subklasifikasi' => ['nullable', 'string'],
            'id_kualifikasi' => ['nullable', 'string', 'max:50'],
            'pelaksana_sertifikasi' => ['nullable', 'string', 'max:255'],
            'tanggal_ditetapkan' => ['nullable'],
            'tanggal_masa_berlaku' => ['nullable'],
            'valid' => ['nullable', 'string', 'max:50'],
            'tgl_update' => ['nullable'],
            'nama_pjbu' => ['nullable', 'string', 'max:255'],
            'nik_pjbu' => ['nullable', 'string', 'max:50'],
            'npwp_pjbu' => ['nullable', 'string', 'max:50'],
            'jenis_perubahan' => ['nullable', 'string', 'max:50'],
            'last_perubahan_at' => ['nullable'],
            'deskripsi_klasifikasi' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:50'],
            'negara_asal' => ['nullable', 'string', 'max:255'],
            'nama_pjtbu' => ['nullable', 'string', 'max:255'],
            'nama_pjskbu' => ['nullable', 'string', 'max:255'],
            'nama_pjskbu_2' => ['nullable', 'string', 'max:255'],
            'id_asosiasi' => ['nullable', 'string', 'max:50'],
        ];
    }

    protected function attributes(): array
    {
        return [
            'id_izin' => 'ID izin',
            'nib' => 'NIB',
            'nama_bu' => 'nama BUJK',
            'jenis_usaha' => 'jenis usaha',
            'email' => 'email',
            'website' => 'website',
        ];
    }

    protected function findExistingRecord(array $record): ?Bujk
    {
        if (!blank($record['id_izin'] ?? null)) {
            return Bujk::query()->where('id_izin', $record['id_izin'])->first();
        }

        $query = Bujk::query()->where('nib', $record['nib']);

        if (!blank($record['kode_subklasifikasi'] ?? null)) {
            $query->where('kode_subklasifikasi', $record['kode_subklasifikasi']);
        }

        if (!blank($record['subklasifikasi'] ?? null)) {
            $query->where('subklasifikasi', $record['subklasifikasi']);
        }

        return $query->first();
    }

    protected function makeSignature(array $record): string
    {
        if (!blank($record['id_izin'] ?? null)) {
            return 'id_izin:' . $record['id_izin'];
        }

        return 'fallback:' . strtolower(implode('|', [
            $record['nib'] ?? '-',
            $record['kode_subklasifikasi'] ?? '-',
            $record['subklasifikasi'] ?? '-',
            $record['tanggal_ditetapkan'] ?? '-',
        ]));
    }
}