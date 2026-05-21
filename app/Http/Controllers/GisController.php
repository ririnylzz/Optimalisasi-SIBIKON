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
        if (!Schema::hasTable('bujk')) {
            return $this->emptyPayload();
        }

        $items = DB::table('bujk')
        
            ->where('is_deleted', 0)
            ->whereIn('kab_kota_bujk', array_keys($this->kodeKabupaten))
            ->get()
            ->map(function ($row) {
                return [
                    'id' => $row->id,
                    'category' => 'bujk',
                    'name' => $row->nama_bujk,
                    'nib' => $row->nib,
                    'jenis_usaha' => $row->jenis_bujk,
                    'alamat' => $row->alamat_bujk,
                    'kabupaten' => $this->kodeKabupaten[$row->kab_kota_bujk] ?? $row->kab_kota_bujk,
                    'kode_kabupaten' => $row->kab_kota_bujk,
                    'provinsi' => 'Kalimantan Timur',
                    'telepon' => $row->telp_bujk,
                    'email' => $row->email_bujk,
                    'website' => $row->website_bujk,
                ];
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

        return $value;
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