<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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
            'bujk' => response()->json($this->sbuData()),
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

    private function sbuData(): array
    {
        $table = 'bujk_sbu';

        if (!Schema::hasTable($table)) {
            return $this->emptyPayload($this->latestDataDateMeta('bujk/latest-data-date.txt'));
        }

        $query = DB::table($table);

        if ($this->hasColumn($table, 'is_deleted')) {
            $query->where(function ($query) {
                $query->whereNull('is_deleted')
                    ->orWhere('is_deleted', 0);
            });
        }

        if ($this->hasColumn($table, 'kabupaten')) {
            $query->whereNotNull('kabupaten')
                ->where('kabupaten', '!=', '');
        }

        $items = $query
            ->orderBy('nama_bu')
            ->orderBy('subklasifikasi')
            ->get()
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

                $kodeSubklasifikasi = $this->value($row, [
                    'kode_subklasifikasi',
                    'Kode_Subklasifikasi',
                    'kode_sub_klasifikasi',
                ]);

                $subklasifikasi = $this->value($row, [
                    'subklasifikasi',
                    'Subklasifikasi',
                    'sub_klasifikasi',
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

                $tanggalMasaBerlaku = $this->value($row, [
                    'tanggal_masa_berlaku',
                    'Tanggal_Masa_Berlaku',
                    'masa_berlaku',
                    'Masa_Berlaku',
                ]);

                return [
                    'id' => $this->value($row, ['id', 'ID']),
                    'category' => 'sbu',
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
                    'asosiasi' => $this->value($row, ['asosiasi', 'Asosiasi']),
                    'klasifikasi' => $this->value($row, ['klasifikasi', 'Klasifikasi']),
                    'kode_subklasifikasi' => $kodeSubklasifikasi,
                    'subklasifikasi' => $subklasifikasi,
                    'subklasifikasi_label' => $this->subklasifikasiLabel($kodeSubklasifikasi, $subklasifikasi),
                    'id_kualifikasi' => $this->value($row, ['id_kualifikasi', 'Id_Kualifikasi', 'ID_Kualifikasi']),
                    'pelaksana_sertifikasi' => $this->value($row, ['pelaksana_sertifikasi', 'Pelaksana_Sertifikasi']),
                    'tanggal_ditetapkan' => $this->value($row, ['tanggal_ditetapkan', 'Tanggal_Ditetapkan']),
                    'tanggal_masa_berlaku' => $tanggalMasaBerlaku,
                    'tanggal_masa_berlaku_label' => $this->dateLabelIndonesia($tanggalMasaBerlaku),
                    'valid' => $this->value($row, ['valid', 'Valid']),
                    'status' => $this->value($row, ['status', 'Status']),
                ];
            })
            ->filter(function ($item) {
                return filled($item['name'])
                    && filled($item['kabupaten']);
            })
            ->values();

        return $this->payload($items, $this->latestDataDateMeta('bujk/latest-data-date.txt'));
    }

    private function tkkData(): array
    {
        $table = 'tkk';

        if (!Schema::hasTable($table)) {
            return $this->emptyPayload($this->latestDataDateMeta('tkk/latest-data-date.txt'));
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

        return $this->payload($items, array_merge([
            'jenjang_options' => $items
                ->pluck('jenjang')
                ->filter()
                ->unique()
                ->sort()
                ->values(),
        ], $this->latestDataDateMeta('tkk/latest-data-date.txt')));
    }

    private function rantaiPasokData(): array
    {
        $table = 'rantai_pasok';

        if (!Schema::hasTable($table)) {
            return $this->emptyPayload($this->latestRantaiPasokDataDateMeta($table));
        }

        $query = DB::table($table);

        if ($this->hasColumn($table, 'is_deleted')) {
            $query->where(function ($query) {
                $query->whereNull('is_deleted')
                    ->orWhere('is_deleted', 0);
            });
        }

        $items = $query
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

        return $this->payload($items, array_merge([
            'bidang_usaha_options' => $items
                ->pluck('bidang_usaha')
                ->filter()
                ->unique()
                ->sort()
                ->values(),
        ], $this->latestRantaiPasokDataDateMeta($table)));
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

    private function latestDataDateMeta(string $path): array
    {
        if (!Storage::disk('local')->exists($path)) {
            return [
                'latest_data_date' => null,
                'latest_data_date_label' => null,
            ];
        }

        $date = trim((string) Storage::disk('local')->get($path));

        return $this->formatLatestDataDate($date);
    }

    private function latestRantaiPasokDataDateMeta(string $table): array
    {
        foreach (['rantai-pasok/latest-data-date.txt', 'rantai_pasok/latest-data-date.txt'] as $path) {
            if (Storage::disk('local')->exists($path)) {
                $date = trim((string) Storage::disk('local')->get($path));

                return $this->formatLatestDataDate($date);
            }
        }

        return $this->latestDataDateFromTableMeta($table);
    }

    private function latestDataDateFromTableMeta(string $table): array
    {
        if (!Schema::hasTable($table)) {
            return [
                'latest_data_date' => null,
                'latest_data_date_label' => null,
            ];
        }

        $dateColumn = null;

        if (Schema::hasColumn($table, 'updated_at')) {
            $dateColumn = 'updated_at';
        } elseif (Schema::hasColumn($table, 'created_at')) {
            $dateColumn = 'created_at';
        }

        if (!$dateColumn) {
            return [
                'latest_data_date' => null,
                'latest_data_date_label' => null,
            ];
        }

        $query = DB::table($table);

        if ($this->hasColumn($table, 'is_deleted')) {
            $query->where(function ($query) {
                $query->whereNull('is_deleted')
                    ->orWhere('is_deleted', 0);
            });
        }

        $date = $query->max($dateColumn);

        return $this->formatLatestDataDate($date);
    }

    private function formatLatestDataDate($date): array
    {
        if (blank($date)) {
            return [
                'latest_data_date' => null,
                'latest_data_date_label' => null,
            ];
        }

        try {
            $carbonDate = Carbon::parse($date);

            return [
                'latest_data_date' => $carbonDate->toDateString(),
                'latest_data_date_label' => $carbonDate
                    ->locale('id')
                    ->translatedFormat('d F Y'),
            ];
        } catch (\Throwable) {
            return [
                'latest_data_date' => (string) $date,
                'latest_data_date_label' => (string) $date,
            ];
        }
    }

    private function emptyPayload(array $extra = []): array
    {
        return array_merge([
            'items' => [],
            'summary' => [],
            'kabupaten_options' => $this->kabupatenOptions(),
        ], $extra);
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

    private function subklasifikasiLabel($kodeSubklasifikasi, $subklasifikasi): string
    {
        $kodeSubklasifikasi = trim((string) $kodeSubklasifikasi);
        $subklasifikasi = trim((string) $subklasifikasi);

        if ($kodeSubklasifikasi !== '' && $subklasifikasi !== '') {
            return $kodeSubklasifikasi . ' - ' . $subklasifikasi;
        }

        if ($subklasifikasi !== '') {
            return $subklasifikasi;
        }

        if ($kodeSubklasifikasi !== '') {
            return $kodeSubklasifikasi;
        }

        return '-';
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

    private function dateLabelIndonesia($date): string
    {
        if (blank($date)) {
            return '-';
        }

        try {
            return Carbon::parse($date)
                ->locale('id')
                ->translatedFormat('d F Y');
        } catch (\Throwable) {
            return (string) $date;
        }
    }
}