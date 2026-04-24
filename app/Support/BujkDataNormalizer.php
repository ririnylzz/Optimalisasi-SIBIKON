<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BujkDataNormalizer
{
    public function normalizeFormInput(array $input): array
    {
        return [
            'nib' => $this->sanitizeIdentifier(Arr::get($input, 'nib')),
            'nama_bujk' => $this->sanitizeText(Arr::get($input, 'nama_bujk')),
            'npwp_bujk' => $this->sanitizeText(Arr::get($input, 'npwp_bujk')),
            'jenis_bujk' => $this->implodeJenisBujk(Arr::get($input, 'jenis_bujk')),
            'alamat_bujk' => $this->sanitizeText(Arr::get($input, 'alamat_bujk')),
            'kab_kota_bujk' => $this->normalizeKabupatenKota(Arr::get($input, 'kab_kota_bujk')),
            'provinsi_bujk' => $this->normalizeProvince(Arr::get($input, 'provinsi_bujk')),
            'telp_bujk' => $this->sanitizePhone(Arr::get($input, 'telp_bujk')),
            'email_bujk' => $this->sanitizeEmail(Arr::get($input, 'email_bujk')),
            'website_bujk' => $this->sanitizeWebsite(Arr::get($input, 'website_bujk')),
            'jumlah_tenaga_kerja' => $this->sanitizeInteger(Arr::get($input, 'jumlah_tenaga_kerja')),
        ];
    }

    public function normalizeImportedRow(array $row): array
    {
        return $this->normalizeFormInput([
            'nib' => $row['nib'] ?? null,
            'nama_bujk' => $row['nama_bujk'] ?? null,
            'npwp_bujk' => $row['npwp_bujk'] ?? null,
            'jenis_bujk' => $row['jenis_bujk'] ?? null,
            'alamat_bujk' => $row['alamat_bujk'] ?? null,
            'kab_kota_bujk' => $row['kab_kota_bujk'] ?? null,
            'provinsi_bujk' => $row['provinsi_bujk'] ?? null,
            'telp_bujk' => $row['telp_bujk'] ?? null,
            'email_bujk' => $row['email_bujk'] ?? null,
            'website_bujk' => $row['website_bujk'] ?? null,
            'jumlah_tenaga_kerja' => $row['jumlah_tenaga_kerja'] ?? null,
        ]);
    }

    public function implodeJenisBujk(mixed $value): ?string
    {
        $jenisList = $this->normalizeJenisBujk($value);

        return empty($jenisList) ? null : implode(', ', $jenisList);
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

    public function normalizeProvince(?string $value): ?string
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

    public function normalizeKabupatenKota(?string $value): ?string
    {
        $lookup = $this->normalizeLookupKey($value);

        if ($lookup === '') {
            return null;
        }

        foreach (config('bujk.regions', []) as $province => $regions) {
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

    public function sanitizeWebsite(mixed $value): ?string
    {
        $normalized = $this->sanitizeText($value);

        return $normalized === null ? null : Str::replace(' ', '', $normalized);
    }

    public function sanitizeInteger(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        $numeric = preg_replace('/[^0-9]/', '', (string) $value);

        return $numeric === '' ? null : (int) $numeric;
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