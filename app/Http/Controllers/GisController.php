<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GisController extends Controller
{
    private array $kodeKabupaten = [
        '64.01' => 'Paser',
        '64.02' => 'Kutai Kartanegara',
        '64.03' => 'Berau',
        '64.07' => 'Kutai Barat',
        '64.08' => 'Kutai Timur',
        '64.09' => 'Penajam Paser Utara',
        '64.11' => 'Mahakam Ulu',
        '64.71' => 'Kota Balikpapan',
        '64.72' => 'Kota Samarinda',
        '64.74' => 'Kota Bontang',
    ];

    public function data(string $category): JsonResponse
    {
        return match ($category) {
            'bujk' => response()->json($this->bujkData()),
            'tkk' => response()->json($this->tkkData()),
            'rantai-pasok' => response()->json($this->rantaiPasokData()),
            default => response()->json([
                'items' => [],
                'summary' => [],
                'kabupaten_options' => $this->kabupatenOptions(),
                'message' => 'Kategori GIS tidak ditemukan.',
            ], 404),
        };
    }

    private function bujkData(): array
    {
        $table = 'bujk';

        if (!Schema::hasTable($table)) {
            return $this->emptyPayload();
        }

        $query = DB::table($table);

        if ($this->hasColumn($table, 'is_deleted')) {
            $query->where(function ($query) {
                $query->whereNull('is_deleted')
                    ->orWhere('is_deleted', 0);
            });
        }

        /*
         * Support dua versi struktur tabel:
         * 1. Struktur lama:
         *    nama_bujk, kab_kota_bujk, jenis_bujk, alamat_bujk, telp_bujk, email_bujk, website_bujk
         *
         * 2. Struktur baru:
         *    nama_bu, kabupaten, jenis_usaha, dan kolom lain sesuai hasil import BUJK.
         */
        if ($this->hasColumn($table, 'kab_kota_bujk')) {
            $query->whereIn('kab_kota_bujk', array_keys($this->kodeKabupaten));
        } elseif ($this->hasColumn($table, 'kabupaten')) {
            $query->whereNotNull('kabupaten')
                ->where('kabupaten', '!=', '');
        }

        $rows = $query->get();

        $items = $rows
            ->map(function ($row) {
                $namaBu = $this->value($row, [
                    'nama_bu',
                    'nama_bujk',
                    'nama',
                    'Nama_BU',
                    'Nama_BUJK',
                ]);

                $nib = $this->value($row, [
                    'nib',
                    'NIB',
                ]);

                $jenisUsaha = $this->value($row, [
                    'jenis_usaha',
                    'jenis_bujk',
                    'Jenis_Usaha',
                    'Jenis_BUJK',
                ]);

                $alamat = $this->value($row, [
                    'alamat',
                    'alamat_bujk',
                    'alamat_bu',
                    'Alamat',
                    'Alamat_BUJK',
                ]);

                $kabupatenRaw = $this->value($row, [
                    'kabupaten',
                    'kab_kota_bujk',
                    'kab_kota',
                    'Kabupaten',
                    'Kab_Kota_BUJK',
                ]);

                $kabupaten = $this->normalizeKabupaten($kabupatenRaw);

                $telepon = $this->value($row, [
                    'telepon',
                    'telp',
                    'telp_bujk',
                    'no_telp',
                    'no_telepon',
                    'nomor_telepon',
                    'kontak',
                    'Telepon',
                ]);

                $email = $this->value($row, [
                    'email',
                    'email_bujk',
                    'Email',
                ]);

                $website = $this->value($row, [
                    'website',
                    'website_bujk',
                    'Website',
                ]);

                $asosiasi = $this->value($row, [
                    'asosiasi',
                    'Asosiasi',
                ]);

                $status = $this->value($row, [
                    'status',
                    'Status',
                ]);

                return [
                    'id' => $this->value($row, ['id', 'ID']),
                    'category' => 'bujk',
                    'name' => $namaBu,
                    'nama_bu' => $namaBu,
                    'nib' => $nib,
                    'jenis_usaha' => $jenisUsaha,
                    'alamat' => $alamat,
                    'kabupaten' => $kabupaten,
                    'kode_kabupaten' => $this->kodeKabupatenByName($kabupaten),
                    'provinsi' => $this->value($row, ['propinsi', 'provinsi', 'Provinsi']) ?: 'Kalimantan Timur',
                    'telepon' => $telepon,
                    'email' => $email,
                    'website' => $website,
                    'asosiasi' => $asosiasi,
                    'status' => $status,
                ];
            })
            ->filter(function ($item) {
                return filled($item['name'])
                    && filled($item['kabupaten']);
            })
            ->values();

        /*
         * Deduplicate berdasarkan NIB.
         * Kalau NIB kosong, fallback berdasarkan nama BU + kabupaten.
         */
        $items = $items
            ->groupBy(function ($item) {
                if (filled($item['nib'])) {
                    return 'nib:' . trim((string) $item['nib']);
                }

                return 'nama:' . strtolower((string) $item['name']) . '|kab:' . strtolower((string) $item['kabupaten']);
            })
            ->map(function ($group) {
                return $group->first();
            })
            ->values();

        return $this->payload($items);
    }

    private function tkkData(): array
    {
        $table = 'tkk';

        if (!Schema::hasTable($table)) {
            return $this->emptyPayload();
        }

        $items = DB::table($table)
            ->get()
            ->map(function ($row) {
                $tanggalKadaluwarsa = $this->value($row, [
                    'Tanggal_Kadaluwarsa',
                    'Tanggal_kadaluwarsa',
                    'tanggal_kadaluwarsa',
                    'tgl_kadaluwarsa',
                ]);

                $status = $this->isExpired($tanggalKadaluwarsa) ? 'kadaluwarsa' : 'aktif';

                return [
                    'id' => $this->value($row, ['id', 'ID']),
                    'category' => 'tkk',
                    'name' => $this->value($row, ['Nama', 'nama']),
                    'kabupaten' => $this->normalizeKabupaten(
                        $this->value($row, ['Kabupaten', 'kabupaten', 'kab_kota'])
                    ),
                    'klasifikasi' => $this->value($row, ['Klasifikasi', 'klasifikasi']),
                    'jabatan_kerja' => $this->value($row, ['Jabatan_Kerja', 'jabatan_kerja']),
                    'jenjang' => $this->value($row, ['Jenjang', 'jenjang']),
                    'asosiasi' => $this->value($row, ['Asosiasi', 'asosiasi']),
                    'tanggal_kadaluwarsa' => $tanggalKadaluwarsa,
                    'tanggal_kadaluwarsa_label' => $this->dateLabel($tanggalKadaluwarsa),
                    'status' => $status,
                    'status_label' => $status === 'kadaluwarsa' ? 'Kadaluwarsa' : 'Aktif',
                ];
            })
            ->filter(fn ($item) => filled($item['kabupaten']))
            ->values();

        return $this->payload($items, [
            'jenjang_options' => $items
                ->pluck('jenjang')
                ->filter()
                ->unique()
                ->sort()
                ->values(),
        ]);
    }

    private function rantaiPasokData(): array
    {
        $table = 'rantai_pasok';

        if (!Schema::hasTable($table)) {
            return $this->emptyPayload();
        }

        $items = DB::table($table)
            ->get()
            ->map(function ($row) {
                return [
                    'id' => $this->value($row, ['id', 'ID']),
                    'category' => 'rantai-pasok',
                    'name' => $this->value($row, ['nama', 'Nama', 'nama_usaha', 'Nama_Usaha']),
                    'bidang_usaha' => $this->value($row, ['bidang_usaha', 'Bidang_Usaha', 'bidang', 'Bidang']),
                    'alamat' => $this->value($row, ['alamat', 'Alamat']),
                    'kabupaten' => $this->normalizeKabupaten(
                        $this->value($row, ['kabupaten', 'Kabupaten', 'kab_kota', 'Kab_Kota'])
                    ),
                ];
            })
            ->filter(fn ($item) => filled($item['kabupaten']))
            ->values();

        return $this->payload($items, [
            'bidang_usaha_options' => $items
                ->pluck('bidang_usaha')
                ->filter()
                ->unique()
                ->sort()
                ->values(),
        ]);
    }

    private function payload(Collection $items, array $extra = []): array
    {
        $summary = $items
            ->groupBy('kabupaten')
            ->map(function ($group, $kabupaten) {
                return [
                    'kabupaten' => $kabupaten,
                    'total' => $group->count(),
                ];
            })
            ->sortByDesc('total')
            ->values();

        return array_merge([
            'items' => $items->values(),
            'summary' => $summary,
            'kabupaten_options' => $this->kabupatenOptions(),
        ], $extra);
    }

    private function emptyPayload(): array
    {
        return [
            'items' => [],
            'summary' => [],
            'kabupaten_options' => $this->kabupatenOptions(),
        ];
    }

    private function kabupatenOptions(): Collection
    {
        return collect($this->kodeKabupaten)
            ->values()
            ->sort()
            ->values();
    }

    private function normalizeKabupaten($value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim((string) $value);

        if (isset($this->kodeKabupaten[$value])) {
            return $this->kodeKabupaten[$value];
        }

        $normalized = preg_replace('/\s+/', ' ', $value);
        $normalized = trim($normalized);

        $withoutPrefix = preg_replace('/^(kab\.?|kabupaten)\s+/i', '', $normalized);
        $withoutPrefix = trim($withoutPrefix);

        foreach ($this->kodeKabupaten as $kode => $kabupaten) {
            if (strtolower($normalized) === strtolower($kabupaten)) {
                return $kabupaten;
            }

            if (strtolower($withoutPrefix) === strtolower($kabupaten)) {
                return $kabupaten;
            }
        }

        return $normalized;
    }

    private function kodeKabupatenByName(?string $name): ?string
    {
        if (blank($name)) {
            return null;
        }

        foreach ($this->kodeKabupaten as $kode => $kabupaten) {
            if (strtolower($kabupaten) === strtolower((string) $name)) {
                return $kode;
            }
        }

        return null;
    }

    private function value(object $row, array $columns): mixed
    {
        foreach ($columns as $column) {
            if (property_exists($row, $column)) {
                return $row->{$column};
            }
        }

        return null;
    }

    private function hasColumn(string $table, string $column): bool
    {
        return Schema::hasColumn($table, $column);
    }

    private function isExpired($date): bool
    {
        if (blank($date)) {
            return false;
        }

        try {
            return Carbon::parse($date)->lt(now()->startOfDay());
        } catch (\Throwable) {
            return false;
        }
    }

    private function dateLabel($date): string
    {
        if (blank($date)) {
            return 'Tidak ada tanggal';
        }

        try {
            return Carbon::parse($date)->format('d-m-Y');
        } catch (\Throwable) {
            return (string) $date;
        }
    }
}