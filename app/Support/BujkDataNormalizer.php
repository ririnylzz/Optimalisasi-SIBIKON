<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BujkDataNormalizer
{
    public function normalizeFormInput(array $input): array
    {
        $jenisList = $this->normalizeJenisList($input['jenis_bujk'] ?? null);

        return [
            'nib' => $this->normalizeNib($input['nib'] ?? null),
            'nama_bujk' => $this->normalizeText($input['nama_bujk'] ?? null, true),
            'jenis_bujk' => $this->serializeJenisList($jenisList),
            'alamat_bujk' => $this->normalizeText($input['alamat_bujk'] ?? null, false),
            'provinsi_bujk' => $this->normalizeText($input['provinsi_bujk'] ?? null, true),
            'kab_kota_bujk' => $this->normalizeText($input['kab_kota_bujk'] ?? null, true),
            'npwp_bujk' => $this->normalizeNpwp($input['npwp_bujk'] ?? null),
            'email_bujk' => $this->normalizeEmail($input['email_bujk'] ?? null),
            'telp_bujk' => $this->normalizePhone($input['telp_bujk'] ?? null),
            'website_bujk' => $this->normalizeWebsite($input['website_bujk'] ?? null),
        ];
    }

    public function normalizeImportRow(array $row): ?array
    {
        $nib = $this->normalizeNib($row['nib'] ?? null);

        if ($nib === null) {
            return null;
        }

        $jenisList = $this->normalizeJenisList($row['jenis_usaha'] ?? $row['jenis_bujk'] ?? null);

        return [
            'nib' => $nib,
            'nama_bujk' => $this->normalizeText($row['nama_bujk'] ?? null, true),
            'jenis_bujk' => $this->serializeJenisList($jenisList),
            'alamat_bujk' => $this->normalizeText($row['alamat'] ?? $row['alamat_bujk'] ?? null, false),
            'provinsi_bujk' => $this->normalizeText($row['provinsi'] ?? $row['provinsi_bujk'] ?? null, true),
            'kab_kota_bujk' => $this->normalizeText($row['kabupaten'] ?? $row['kab_kota_bujk'] ?? null, true),
            'npwp_bujk' => $this->normalizeNpwp($row['npwp'] ?? $row['npwp_bujk'] ?? null),
            'email_bujk' => $this->normalizeEmail($row['email'] ?? $row['email_bujk'] ?? null),
            'telp_bujk' => $this->normalizePhone($row['no_telp'] ?? $row['telp_bujk'] ?? null),
            'website_bujk' => $this->normalizeWebsite($row['website'] ?? $row['website_bujk'] ?? null),
        ];
    }

    public function mergeDuplicateImportRows(array $base, array $incoming): array
    {
        return [
            'nib' => $incoming['nib'] ?? $base['nib'],
            'nama_bujk' => $this->preferIncoming($base['nama_bujk'] ?? null, $incoming['nama_bujk'] ?? null),
            'jenis_bujk' => $this->mergeJenisSerialized($base['jenis_bujk'] ?? null, $incoming['jenis_bujk'] ?? null),
            'alamat_bujk' => $this->preferIncoming($base['alamat_bujk'] ?? null, $incoming['alamat_bujk'] ?? null),
            'provinsi_bujk' => $this->preferIncoming($base['provinsi_bujk'] ?? null, $incoming['provinsi_bujk'] ?? null),
            'kab_kota_bujk' => $this->preferIncoming($base['kab_kota_bujk'] ?? null, $incoming['kab_kota_bujk'] ?? null),
            'npwp_bujk' => $this->preferIncoming($base['npwp_bujk'] ?? null, $incoming['npwp_bujk'] ?? null),
            'email_bujk' => $this->preferIncoming($base['email_bujk'] ?? null, $incoming['email_bujk'] ?? null),
            'telp_bujk' => $this->preferIncoming($base['telp_bujk'] ?? null, $incoming['telp_bujk'] ?? null),
            'website_bujk' => $this->preferIncoming($base['website_bujk'] ?? null, $incoming['website_bujk'] ?? null),
        ];
    }

    public function mergeImportedWithExisting(object $existing, array $incoming): array
    {
        return [
            'nib' => $incoming['nib'] ?? (string) $existing->nib,
            'nama_bujk' => $this->preferIncoming($existing->nama_bujk ?? null, $incoming['nama_bujk'] ?? null),
            'jenis_bujk' => $this->preferIncomingJenis($existing->jenis_bujk ?? null, $incoming['jenis_bujk'] ?? null),
            'alamat_bujk' => $this->preferIncoming($existing->alamat_bujk ?? null, $incoming['alamat_bujk'] ?? null),
            'provinsi_bujk' => $this->preferIncoming($existing->provinsi_bujk ?? null, $incoming['provinsi_bujk'] ?? null),
            'kab_kota_bujk' => $this->preferIncoming($existing->kab_kota_bujk ?? null, $incoming['kab_kota_bujk'] ?? null),
            'npwp_bujk' => $this->preferIncoming($existing->npwp_bujk ?? null, $incoming['npwp_bujk'] ?? null),
            'email_bujk' => $this->preferIncoming($existing->email_bujk ?? null, $incoming['email_bujk'] ?? null),
            'telp_bujk' => $this->preferIncoming($existing->telp_bujk ?? null, $incoming['telp_bujk'] ?? null),
            'website_bujk' => $this->preferIncoming($existing->website_bujk ?? null, $incoming['website_bujk'] ?? null),
            'is_deleted' => false,
        ];
    }

    protected function preferIncoming(mixed $old, mixed $incoming): ?string
    {
        $incoming = $this->emptyToNull($incoming);

        if ($incoming !== null) {
            return $incoming;
        }

        return $this->emptyToNull($old);
    }

    protected function preferIncomingJenis(mixed $old, mixed $incoming): ?string
    {
        $incoming = $this->emptyToNull($incoming);

        if ($incoming !== null) {
            return $incoming;
        }

        return $this->emptyToNull($old);
    }

    protected function normalizeNib(mixed $value): ?string
    {
        $value = $this->emptyToNull($value);

        if ($value === null) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', (string) $value);

        return $digits !== '' ? $digits : null;
    }

    protected function normalizeNpwp(mixed $value): ?string
    {
        $value = $this->emptyToNull($value);

        if ($value === null) {
            return null;
        }

        return trim((string) $value);
    }

    protected function normalizeEmail(mixed $value): ?string
    {
        $value = $this->emptyToNull($value);

        if ($value === null) {
            return null;
        }

        return Str::lower(trim((string) $value));
    }

    protected function normalizePhone(mixed $value): ?string
    {
        $value = $this->emptyToNull($value);

        if ($value === null) {
            return null;
        }

        return preg_replace('/\s+/', '', (string) $value);
    }

    protected function normalizeWebsite(mixed $value): ?string
    {
        $value = $this->emptyToNull($value);

        if ($value === null) {
            return null;
        }

        return trim((string) $value);
    }

    protected function normalizeText(mixed $value, bool $uppercase = false): ?string
    {
        $value = $this->emptyToNull($value);

        if ($value === null) {
            return null;
        }

        $value = preg_replace('/\s+/u', ' ', trim((string) $value));

        if ($uppercase) {
            $value = Str::upper($value);
        }

        return $value;
    }

    protected function normalizeJenisList(mixed $value): array
    {
        if (is_array($value)) {
            $items = $value;
        } else {
            $raw = $this->emptyToNull($value);

            if ($raw === null) {
                return [];
            }

            $items = preg_split('/[,;\/|\n\r]+/u', (string) $raw) ?: [];
        }

        return collect($items)
            ->map(fn ($item) => $this->mapJenisLabel($item))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    protected function mapJenisLabel(mixed $value): ?string
    {
        $value = Str::lower(trim((string) $value));

        if ($value === '') {
            return null;
        }

        if (str_contains($value, 'konsultan')) {
            return 'Konsultan Konstruksi';
        }

        if (str_contains($value, 'konstruksi')) {
            return 'Konstruksi';
        }

        return null;
    }

    protected function serializeJenisList(array $items): ?string
    {
        $items = collect($items)
            ->filter()
            ->unique()
            ->values()
            ->all();

        return empty($items) ? null : implode(', ', $items);
    }

    protected function mergeJenisSerialized(mixed $base, mixed $incoming): ?string
    {
        $baseItems = $this->normalizeJenisList($base);
        $incomingItems = $this->normalizeJenisList($incoming);

        $merged = collect([...$baseItems, ...$incomingItems])
            ->filter()
            ->unique()
            ->values()
            ->all();

        return $this->serializeJenisList($merged);
    }

    protected function emptyToNull(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}