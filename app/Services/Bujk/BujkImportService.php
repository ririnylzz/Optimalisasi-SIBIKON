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
            $record = $this->cleanRecord($record);

            $validator = Validator::make($record, $this->rules(), $this->messages(), $this->attributes());

            if ($validator->fails()) {
                $prefix = $rowNumber ? 'Baris ' . $rowNumber . ': ' : '';
                $errors[] = $prefix . $validator->errors()->first();
                continue;
            }

            /*
             * Kunci duplikat import hanya berdasarkan NIB yang sudah dinormalisasi.
             *
             * Contoh dianggap sama:
             * 0220003542079
             * 220003542079
             *
             * Karena di file Excel kadang leading zero hilang akibat format angka.
             */
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
        $deduplicated = 0;

        DB::transaction(function () use (&$created, &$updated, &$untouched, &$deduplicated, $preparedRows): void {
            /*
             * File upload dianggap sumber data terbaru.
             * Jadi semua data aktif lama dinonaktifkan dulu.
             * Setelah itu hanya data unik berdasarkan NIB normalisasi
             * yang diaktifkan kembali.
             */
            Bujk::query()
                ->where('is_deleted', false)
                ->update([
                    'is_deleted' => true,
                    'updated_at' => now(),
                ]);

            foreach ($preparedRows as $record) {
                $existing = $this->findExistingRecord($record);

                if ($existing) {
                    $existing->fill($record);
                    $existing->is_deleted = false;
                    $existing->updated_at = now();

                    if ($existing->isDirty()) {
                        $existing->save();
                        $updated++;
                    } else {
                        $untouched++;
                    }

                    /*
                     * Nonaktifkan record lain yang punya NIB sama secara normalisasi.
                     */
                    $duplicateCount = Bujk::query()
                        ->whereIn('nib', $this->nibLookupVariants($record['nib'] ?? null))
                        ->where('id', '<>', $existing->id)
                        ->update([
                            'is_deleted' => true,
                            'updated_at' => now(),
                        ]);

                    $deduplicated += $duplicateCount;

                    continue;
                }

                Bujk::query()->create($record + [
                    'is_deleted' => false,
                ]);

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
            'deduplicated' => $deduplicated,
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

    protected function messages(): array
    {
        return [
            'nib.required' => 'NIB wajib diisi.',
            'nib.string' => 'NIB harus berupa teks.',
            'nib.max' => 'NIB maksimal :max karakter.',

            'nama_bu.required' => 'Nama BUJK wajib diisi.',
            'nama_bu.string' => 'Nama BUJK harus berupa teks.',
            'nama_bu.max' => 'Nama BUJK maksimal :max karakter.',

            'jenis_usaha.required' => 'Jenis usaha wajib diisi.',
            'jenis_usaha.string' => 'Jenis usaha harus berupa teks.',
            'jenis_usaha.max' => 'Jenis usaha maksimal :max karakter.',

            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal :max karakter.',

            '*.string' => ':attribute harus berupa teks.',
            '*.max' => ':attribute maksimal :max karakter.',
        ];
    }

    protected function attributes(): array
    {
        return [
            'id_izin' => 'ID izin',
            'nib' => 'NIB',
            'npwp' => 'NPWP',
            'asosiasi' => 'asosiasi',
            'nama_bu' => 'nama BUJK',
            'bentuk_usaha' => 'bentuk usaha',
            'alamat' => 'alamat',
            'telepon' => 'telepon',
            'email' => 'email',
            'website' => 'website',
            'faksimili' => 'faksimili',
            'propinsi' => 'provinsi',
            'kabupaten' => 'kabupaten/kota',
            'jenis_usaha' => 'jenis usaha',
            'sifat' => 'sifat',
            'kbli_bener' => 'KBLI benar',
            'kbli_inputan' => 'KBLI inputan',
            'ket_kbli' => 'keterangan KBLI',
            'bentuk_badan_usaha' => 'bentuk badan usaha',
            'klasifikasi' => 'klasifikasi',
            'kode_subklasifikasi' => 'kode subklasifikasi',
            'subklasifikasi' => 'subklasifikasi',
            'id_kualifikasi' => 'ID kualifikasi',
            'pelaksana_sertifikasi' => 'pelaksana sertifikasi',
            'tanggal_ditetapkan' => 'tanggal ditetapkan',
            'tanggal_masa_berlaku' => 'tanggal masa berlaku',
            'valid' => 'valid',
            'tgl_update' => 'tanggal update',
            'nama_pjbu' => 'nama PJBU',
            'nik_pjbu' => 'NIK PJBU',
            'npwp_pjbu' => 'NPWP PJBU',
            'jenis_perubahan' => 'jenis perubahan',
            'last_perubahan_at' => 'tanggal perubahan terakhir',
            'deskripsi_klasifikasi' => 'deskripsi klasifikasi',
            'status' => 'status',
            'negara_asal' => 'negara asal',
            'nama_pjtbu' => 'nama PJTBU',
            'nama_pjskbu' => 'nama PJSKBU',
            'nama_pjskbu_2' => 'nama PJSKBU 2',
            'id_asosiasi' => 'ID asosiasi',
        ];
    }

    protected function cleanRecord(array $record): array
    {
        $cleaned = [];

        foreach (array_keys($this->rules()) as $field) {
            $value = $record[$field] ?? null;

            if (is_string($value)) {
                $value = trim(preg_replace('/\s+/u', ' ', $value) ?? $value);
            }

            if ($value === '') {
                $value = null;
            }

            if ($field === 'nib' && !blank($value)) {
                /*
                 * Simpan NIB sebagai angka string bersih.
                 * Leading zero tetap disimpan kalau memang ada di file.
                 */
                $digits = preg_replace('/\D+/u', '', (string) $value);
                $value = $digits !== '' ? $digits : preg_replace('/\s+/u', '', (string) $value);
            }

            $cleaned[$field] = $value;
        }

        return $cleaned;
    }

    protected function findExistingRecord(array $record): ?Bujk
    {
        /*
         * Cari exact dulu.
         */
        $exact = Bujk::query()
            ->where('nib', $record['nib'])
            ->orderBy('id')
            ->first();

        if ($exact) {
            return $exact;
        }

        /*
         * Kalau tidak ada exact, cari varian NIB:
         * 0220003542079 dan 220003542079 dianggap sama.
         */
        return Bujk::query()
            ->whereIn('nib', $this->nibLookupVariants($record['nib'] ?? null))
            ->orderBy('id')
            ->first();
    }

    protected function makeSignature(array $record): string
    {
        /*
         * Signature import hanya berdasarkan NIB normalisasi.
         * Leading zero diabaikan khusus untuk pendeteksian duplikat.
         */
        return 'nib:' . $this->normalizeNibForDuplicate($record['nib'] ?? null);
    }

    protected function normalizeNibForDuplicate(mixed $nib): string
    {
        if (blank($nib)) {
            return '';
        }

        $digits = preg_replace('/\D+/u', '', (string) $nib);

        if ($digits === null || $digits === '') {
            return mb_strtolower(trim((string) $nib));
        }

        /*
         * Ini kunci supaya:
         * 0220003542079
         * 220003542079
         * dianggap NIB yang sama.
         */
        $normalized = ltrim($digits, '0');

        return $normalized === '' ? '0' : $normalized;
    }

    protected function nibLookupVariants(mixed $nib): array
    {
        $variants = [];

        if (!blank($nib)) {
            $raw = preg_replace('/\D+/u', '', (string) $nib);
            $raw = $raw !== null && $raw !== '' ? $raw : trim((string) $nib);

            if ($raw !== '') {
                $variants[] = $raw;
            }
        }

        $normalized = $this->normalizeNibForDuplicate($nib);

        if ($normalized !== '') {
            $variants[] = $normalized;

            /*
             * NIB di file banyak yang 13 digit.
             * Jadi tambahkan versi padding 13 digit untuk menangkap data
             * yang sebelumnya tersimpan dengan leading zero.
             */
            $variants[] = str_pad($normalized, 13, '0', STR_PAD_LEFT);
        }

        return array_values(array_unique(array_filter($variants, fn ($value) => $value !== '')));
    }

    protected function mergeRows(array $base, array $incoming): array
    {
        $merged = [];

        foreach (array_keys($this->rules()) as $field) {
            $merged[$field] = $this->preferValue($base[$field] ?? null, $incoming[$field] ?? null);
        }

        /*
         * Kalau NIB sama tapi salah satu versi kehilangan leading zero,
         * simpan NIB yang lebih panjang/lengkap.
         */
        $merged['nib'] = $this->preferLongerValue($base['nib'] ?? null, $incoming['nib'] ?? null);

        /*
         * Identitas utama dipilih yang paling lengkap.
         */
        $merged['nama_bu'] = $this->preferLongerValue($base['nama_bu'] ?? null, $incoming['nama_bu'] ?? null);
        $merged['alamat'] = $this->preferLongerValue($base['alamat'] ?? null, $incoming['alamat'] ?? null);

        /*
         * Informasi yang bisa muncul berbeda pada NIB yang sama digabung.
         */
        $merged['jenis_usaha'] = $this->mergeUniqueText($base['jenis_usaha'] ?? null, $incoming['jenis_usaha'] ?? null, ', ', 255);
        $merged['sifat'] = $this->mergeUniqueText($base['sifat'] ?? null, $incoming['sifat'] ?? null, ', ', 255);
        $merged['klasifikasi'] = $this->mergeUniqueText($base['klasifikasi'] ?? null, $incoming['klasifikasi'] ?? null, ' | ', 255);
        $merged['subklasifikasi'] = $this->mergeUniqueText($base['subklasifikasi'] ?? null, $incoming['subklasifikasi'] ?? null, ' | ', null);
        $merged['kode_subklasifikasi'] = $this->mergeUniqueText($base['kode_subklasifikasi'] ?? null, $incoming['kode_subklasifikasi'] ?? null, ', ', 50);
        $merged['ket_kbli'] = $this->mergeUniqueText($base['ket_kbli'] ?? null, $incoming['ket_kbli'] ?? null, ' | ', null);
        $merged['deskripsi_klasifikasi'] = $this->mergeUniqueText($base['deskripsi_klasifikasi'] ?? null, $incoming['deskripsi_klasifikasi'] ?? null, ' | ', null);

        return $merged;
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

        return mb_strlen($incoming) > mb_strlen($base) ? $incoming : $base;
    }

    protected function mergeUniqueText(mixed $base, mixed $incoming, string $separator = ' | ', ?int $maxLength = null): ?string
    {
        $values = [];

        foreach ([$base, $incoming] as $value) {
            if (blank($value)) {
                continue;
            }

            $parts = [$value];

            if ($separator === ', ') {
                $parts = preg_split('/\s*,\s*/u', (string) $value) ?: [$value];
            } elseif (str_contains((string) $value, ' | ')) {
                $parts = preg_split('/\s+\|\s+/u', (string) $value) ?: [$value];
            }

            foreach ($parts as $part) {
                $part = trim((string) $part);

                if ($part === '') {
                    continue;
                }

                $key = mb_strtolower($part);

                if (!array_key_exists($key, $values)) {
                    $values[$key] = $part;
                }
            }
        }

        if (empty($values)) {
            return null;
        }

        $merged = implode($separator, array_values($values));

        if ($maxLength !== null && mb_strlen($merged) > $maxLength) {
            return mb_substr($merged, 0, $maxLength);
        }

        return $merged;
    }
}