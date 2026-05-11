<?php

namespace App\Support;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class BujkDataNormalizer
{
    public function normalizeFormInput(array $input): array
    {
        return [
            'id_izin' => $this->sanitizeText($this->first($input, ['id_izin'])),
            'nib' => $this->sanitizeIdentifier($this->first($input, ['nib'])),
            'npwp' => $this->sanitizeText($this->first($input, ['npwp', 'npwp_bujk'])),
            'asosiasi' => $this->sanitizeUpperText($this->first($input, ['asosiasi'])),
            'nama_bu' => $this->sanitizeUpperText($this->first($input, ['nama_bu', 'nama_bujk'])),
            'bentuk_usaha' => $this->sanitizeText($this->first($input, ['bentuk_usaha'])),
            'alamat' => $this->sanitizeText($this->first($input, ['alamat', 'alamat_bujk'])),
            'telepon' => $this->sanitizePhone($this->first($input, ['telepon', 'telp_bujk', 'telp'])),
            'email' => $this->sanitizeEmail($this->first($input, ['email', 'email_bujk'])),
            'website' => $this->sanitizeWebsite($this->first($input, ['website', 'website_bujk'])),
            'faksimili' => $this->sanitizePhone($this->first($input, ['faksimili'])),
            'propinsi' => $this->normalizeProvince($this->first($input, ['propinsi', 'provinsi_bujk', 'provinsi'])),
            'kabupaten' => $this->normalizeKabupatenKota($this->first($input, ['kabupaten', 'kab_kota_bujk', 'kab_kota'])),
            'jenis_usaha' => $this->implodeJenisUsaha($this->first($input, ['jenis_usaha', 'jenis_bujk'])),
            'sifat' => $this->sanitizeText($this->first($input, ['sifat'])),
            'kbli_bener' => $this->sanitizeIdentifier($this->first($input, ['kbli_bener'])),
            'kbli_inputan' => $this->sanitizeIdentifier($this->first($input, ['kbli_inputan'])),
            'ket_kbli' => $this->sanitizeText($this->first($input, ['ket_kbli'])),
            'bentuk_badan_usaha' => $this->sanitizeText($this->first($input, ['bentuk_badan_usaha'])),
            'klasifikasi' => $this->sanitizeText($this->first($input, ['klasifikasi'])),
            'kode_subklasifikasi' => $this->sanitizeText($this->first($input, ['kode_subklasifikasi'])),
            'subklasifikasi' => $this->sanitizeText($this->first($input, ['subklasifikasi'])),
            'id_kualifikasi' => $this->sanitizeText($this->first($input, ['id_kualifikasi'])),
            'pelaksana_sertifikasi' => $this->sanitizeText($this->first($input, ['pelaksana_sertifikasi'])),
            'tanggal_ditetapkan' => $this->sanitizeDateTime($this->first($input, ['tanggal_ditetapkan'])),
            'tanggal_masa_berlaku' => $this->sanitizeDateTime($this->first($input, ['tanggal_masa_berlaku'])),
            'valid' => $this->sanitizeText($this->first($input, ['valid'])),
            'tgl_update' => $this->sanitizeDateTime($this->first($input, ['tgl_update'])),
            'nama_pjbu' => $this->sanitizeText($this->first($input, ['nama_pjbu'])),
            'nik_pjbu' => $this->sanitizeIdentifier($this->first($input, ['nik_pjbu'])),
            'npwp_pjbu' => $this->sanitizeText($this->first($input, ['npwp_pjbu'])),
            'jenis_perubahan' => $this->sanitizeText($this->first($input, ['jenis_perubahan'])),
            'last_perubahan_at' => $this->sanitizeDateTime($this->first($input, ['last_perubahan_at'])),
            'deskripsi_klasifikasi' => $this->sanitizeText($this->first($input, ['deskripsi_klasifikasi'])),
            'status' => $this->sanitizeText($this->first($input, ['status'])),
            'negara_asal' => $this->sanitizeText($this->first($input, ['negara_asal'])),
            'nama_pjtbu' => $this->sanitizeText($this->first($input, ['nama_pjtbu'])),
            'nama_pjskbu' => $this->sanitizeText($this->first($input, ['nama_pjskbu'])),
            'nama_pjskbu_2' => $this->sanitizeText($this->first($input, ['nama_pjskbu_2'])),
            'id_asosiasi' => $this->sanitizeText($this->first($input, ['id_asosiasi'])),
        ];
    }

    public function sanitizeWebsite(mixed $value): ?string
    {
        $normalized = $this->sanitizeText($value);

        if ($normalized === null) {
            return null;
        }

        return preg_replace('/\s+/', '', $normalized);
    }

    public function normalizeImportedRow(array $row): array
    {
        return $this->normalizeFormInput($row);
    }

    public function implodeJenisUsaha(mixed $value): ?string
    {
        $jenisList = $this->normalizeJenisBujk($value);

        return empty($jenisList) ? $this->sanitizeText($value) : implode(', ', $jenisList);
    }

    public function implodeJenisBujk(mixed $value): ?string
    {
        return $this->implodeJenisUsaha($value);
    }

    public function normalizeJenisBujk(mixed $value): array
    {
        $values = is_array($value)
            ? $value
            : preg_split('/[;,|\/]+/', (string) $value, -1, PREG_SPLIT_NO_EMPTY);

        $normalized = collect($values)
            ->map(function ($item) {
                $item = $this->normalizeLookupKey($item);

                return match (true) {
                    str_contains($item, 'konsultan') || str_contains($item, 'jasa konsultasi') => 'Konsultan Konstruksi',
                    str_contains($item, 'terintegrasi') => 'Konstruksi',
                    str_contains($item, 'pekerjaan konstruksi') || $item === 'konstruksi' => 'Konstruksi',
                    default => null,
                };
            })
            ->filter()
            ->unique();

        $ordered = collect(config('bujk.jenis_usaha', []))
            ->filter(static fn ($label) => $normalized->contains($label))
            ->values()
            ->all();

        return empty($ordered) ? $normalized->values()->all() : $ordered;
    }

    public function normalizeProvince(mixed $value): ?string
    {
        $lookup = $this->normalizeLookupKey($value);

        if ($lookup === '') {
            return null;
        }

        foreach (array_keys(config('bujk.regions', [])) as $province) {
            $provinceLookup = $this->normalizeLookupKey($province);
            $provinceShort = $this->normalizeLookupKey(str_replace('KALIMANTAN ', '', $province));

            if ($lookup === $provinceLookup || $lookup === $provinceShort) {
                return $province;
            }
        }

        return $this->sanitizeUpperText($value);
    }

    public function normalizeKabupatenKota(mixed $value): ?string
    {
        $lookup = $this->normalizeLookupKey($value);

        if ($lookup === '') {
            return null;
        }

        foreach (config('bujk.regions', []) as $regions) {
            foreach ($regions as $region) {
                $canonicalLookup = $this->normalizeLookupKey($region);
                $withoutPrefixLookup = $this->normalizeLookupKey(
                    str_replace(['KABUPATEN ', 'KOTA '], '', $region)
                );

                if (in_array($lookup, [$canonicalLookup, $withoutPrefixLookup], true)) {
                    return $region;
                }
            }
        }

        if (Str::startsWith($lookup, 'kab ')) {
            return 'KABUPATEN ' . $this->sanitizeUpperText(Str::after($lookup, 'kab '));
        }

        if (Str::startsWith($lookup, 'kabupaten ')) {
            return 'KABUPATEN ' . $this->sanitizeUpperText(Str::after($lookup, 'kabupaten '));
        }

        if (Str::startsWith($lookup, 'kota ')) {
            return 'KOTA ' . $this->sanitizeUpperText(Str::after($lookup, 'kota '));
        }

        return $this->sanitizeUpperText($value);
    }

    public function sanitizeIdentifier(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = preg_replace('/\s+/', '', trim((string) $value));

        return $normalized === '' ? null : $normalized;
    }

    public function sanitizePhone(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = preg_replace('/\s+/', '', trim((string) $value));

        return $normalized === '' ? null : $normalized;
    }

    public function sanitizeEmail(mixed $value): ?string
    {
        $normalized = $this->sanitizeText($value);

        return $normalized === null ? null : Str::lower($normalized);
    }

    public function sanitizeInteger(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        $numeric = preg_replace('/[^0-9]/', '', (string) $value);

        return $numeric === '' ? null : (int) $numeric;
    }

    public function sanitizeDateTime(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof DateTimeInterface) {
            return Carbon::instance($value)->format('Y-m-d H:i:s');
        }

        try {
            if (is_numeric($value)) {
                return Carbon::instance(ExcelDate::excelToDateTimeObject((float) $value))->format('Y-m-d H:i:s');
            }

            return Carbon::parse((string) $value)->format('Y-m-d H:i:s');
        } catch (\Throwable) {
            return $this->sanitizeText($value);
        }
    }

    public function sanitizeText(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = preg_replace('/\s+/', ' ', trim((string) $value));

        return $normalized === '' ? null : $normalized;
    }

    public function sanitizeUpperText(mixed $value): ?string
    {
        $normalized = $this->sanitizeText($value);

        return $normalized === null ? null : strtoupper($normalized);
    }

    protected function first(array $input, array $keys): mixed
    {
        foreach ($keys as $key) {
            if (Arr::exists($input, $key)) {
                return Arr::get($input, $key);
            }
        }

        return null;
    }

    protected function normalizeLookupKey(mixed $value): string
    {
        if ($value === null) {
            return '';
        }

        return (string) Str::of((string) $value)
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/i', ' ')
            ->squish();
    }
}