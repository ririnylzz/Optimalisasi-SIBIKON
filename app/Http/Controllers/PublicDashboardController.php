<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PublicDashboardController extends Controller
{
    public function tenagaKerja()
    {
        $items = $this->getPublicTkkItems()
            ->filter(fn ($item) => in_array((string) $item['jenjang'], ['7', '8', '9'], true))
            ->values();

        $totalTkk = $items->count();

        $totalWilayah = $items
            ->pluck('kabupaten')
            ->filter()
            ->unique()
            ->count();

        $distribusiJenjang = $items
            ->filter(fn ($item) => filled($item['jenjang']))
            ->groupBy('jenjang')
            ->map(fn ($group, $jenjang) => [
                'label' => 'Jenjang ' . $jenjang,
                'value' => $group->count(),
                'raw_label' => (string) $jenjang,
            ])
            ->sortBy(fn ($item) => (int) $item['raw_label'])
            ->map(fn ($item) => [
                'label' => $item['label'],
                'value' => $item['value'],
            ])
            ->values();

        $topAsosiasi = $items
            ->filter(fn ($item) => filled($item['asosiasi']))
            ->groupBy('asosiasi')
            ->map(fn ($group, $asosiasi) => [
                'label' => $asosiasi,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $topKlasifikasi = $items
            ->filter(fn ($item) => filled($item['klasifikasi']))
            ->groupBy('klasifikasi')
            ->map(fn ($group, $klasifikasi) => [
                'label' => $klasifikasi,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $perbandinganKabupaten = $items
            ->filter(fn ($item) => filled($item['kabupaten']))
            ->groupBy('kabupaten')
            ->map(fn ($group, $kabupaten) => [
                'label' => $kabupaten,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->values();

        $proyeksiKadaluarsa = collect(range(0, 5))
            ->map(function ($yearOffset) use ($items) {
                $year = now()->year + $yearOffset;

                return [
                    'label' => (string) $year,
                    'value' => $items
                        ->filter(fn ($item) => $this->isSameExpiredYear($item['tanggal_kadaluwarsa'], $year))
                        ->count(),
                ];
            })
            ->values();

        return view('pages.dashboard-tkk-publik', [
            'totalTkk' => $totalTkk,
            'totalWilayah' => $totalWilayah,
            'distribusiJenjang' => $distribusiJenjang,
            'topAsosiasi' => $topAsosiasi,
            'topKlasifikasi' => $topKlasifikasi,
            'perbandinganKabupaten' => $perbandinganKabupaten,
            'proyeksiKadaluarsa' => $proyeksiKadaluarsa,
        ]);
    }

    public function bujk()
    {
        $items = $this->getPublicBujkItems();

        $totalBujk = $items->count();

        $totalWilayah = $items
            ->pluck('kabupaten')
            ->filter()
            ->unique()
            ->count();

        $totalKonstruksi = $items
            ->filter(fn ($item) => str_contains(strtolower((string) $item['jenis_usaha']), 'konstruksi'))
            ->count();

        $totalKonsultan = $items
            ->filter(fn ($item) => str_contains(strtolower((string) $item['jenis_usaha']), 'konsultan'))
            ->count();

        $totalKontak = $items
            ->filter(fn ($item) => filled($item['telepon']) || filled($item['email']) || filled($item['website']))
            ->count();

        $kpi = [
            [
                'label' => 'Total BUJK',
                'value' => $totalBujk,
                'caption' => 'Badan usaha jasa konstruksi',
            ],
            [
                'label' => 'Wilayah',
                'value' => $totalWilayah,
                'caption' => 'Kabupaten/kota terdata',
            ],
            [
                'label' => 'Konstruksi',
                'value' => $totalKonstruksi,
                'caption' => 'Jenis usaha konstruksi',
            ],
            [
                'label' => 'Konsultan',
                'value' => $totalKonsultan,
                'caption' => 'Jenis usaha konsultan',
            ],
        ];

        $jenisUsahaSummary = $items
            ->filter(fn ($item) => filled($item['jenis_usaha']))
            ->groupBy('jenis_usaha')
            ->map(fn ($group, $jenisUsaha) => [
                'label' => $jenisUsaha,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->values();

        $kabupatenSummary = $items
            ->filter(fn ($item) => filled($item['kabupaten']))
            ->groupBy('kabupaten')
            ->map(fn ($group, $kabupaten) => [
                'label' => $kabupaten,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->values();

        $kontakSummary = collect([
            [
                'label' => 'Ada Kontak',
                'value' => $totalKontak,
            ],
            [
                'label' => 'Belum Ada Kontak',
                'value' => max($totalBujk - $totalKontak, 0),
            ],
        ]);

        $latestBujk = $items
            ->sortByDesc('id')
            ->take(8)
            ->values();

        return view('pages.dashboard-bujk-publik', [
            'kpi' => $kpi,
            'totalBujk' => $totalBujk,
            'totalWilayah' => $totalWilayah,
            'jenisUsahaSummary' => $jenisUsahaSummary,
            'kabupatenSummary' => $kabupatenSummary,
            'kontakSummary' => $kontakSummary,
            'latestBujk' => $latestBujk,
        ]);
    }

    public function sbu()
    {
        $items = $this->getPublicSbuItems();

        $totalSbu = $items->count();

        $totalWilayah = $items
            ->pluck('kabupaten')
            ->filter()
            ->unique()
            ->count();

        $totalKonstruksi = $items
            ->filter(fn ($item) => str_contains(strtolower((string) $item['jenis_usaha']), 'konstruksi'))
            ->count();

        $totalKonsultan = $items
            ->filter(fn ($item) => str_contains(strtolower((string) $item['jenis_usaha']), 'konsultan'))
            ->count();

        $kpi = [
            [
                'label' => 'Total SBU',
                'value' => $totalSbu,
                'caption' => 'Sertifikat badan usaha',
            ],
            [
                'label' => 'Wilayah',
                'value' => $totalWilayah,
                'caption' => 'Kabupaten/kota terdata',
            ],
            [
                'label' => 'Konstruksi',
                'value' => $totalKonstruksi,
                'caption' => 'Jenis usaha konstruksi',
            ],
            [
                'label' => 'Konsultan',
                'value' => $totalKonsultan,
                'caption' => 'Jenis usaha konsultan',
            ],
        ];

        $jenisUsahaSummary = $items
            ->filter(fn ($item) => filled($item['jenis_usaha']))
            ->groupBy('jenis_usaha')
            ->map(fn ($group, $jenisUsaha) => [
                'label' => $jenisUsaha,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->values();

        $kabupatenSummary = $items
            ->filter(fn ($item) => filled($item['kabupaten']))
            ->groupBy('kabupaten')
            ->map(fn ($group, $kabupaten) => [
                'label' => $kabupaten,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->values();

        $asosiasiSummary = $items
            ->filter(fn ($item) => filled($item['asosiasi']))
            ->groupBy('asosiasi')
            ->map(fn ($group, $asosiasi) => [
                'label' => $asosiasi,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        if ($asosiasiSummary->isEmpty()) {
            $asosiasiSummary = $jenisUsahaSummary
                ->take(5)
                ->values();
        }

        $pelaksanaSummary = $items
            ->filter(fn ($item) => filled($item['pelaksana']))
            ->groupBy('pelaksana')
            ->map(fn ($group, $pelaksana) => [
                'label' => $pelaksana,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        if ($pelaksanaSummary->isEmpty()) {
            $pelaksanaSummary = $asosiasiSummary;
        }

        $kbliSummary = $items
            ->filter(fn ($item) => filled($item['kbli']))
            ->groupBy('kbli')
            ->map(fn ($group, $kbli) => [
                'label' => $kbli,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        if ($kbliSummary->isEmpty()) {
            $kbliSummary = $jenisUsahaSummary
                ->take(5)
                ->values();
        }

        $latestSbu = $items
            ->sortByDesc('id')
            ->take(8)
            ->values();

        return view('pages.dashboard-sbu-publik', [
            'kpi' => $kpi,
            'totalSbu' => $totalSbu,
            'totalWilayah' => $totalWilayah,
            'jenisUsahaSummary' => $jenisUsahaSummary,
            'kabupatenSummary' => $kabupatenSummary,
            'asosiasiSummary' => $asosiasiSummary,
            'pelaksanaSummary' => $pelaksanaSummary,
            'kbliSummary' => $kbliSummary,
            'latestSbu' => $latestSbu,
        ]);
    }

    private function getPublicSbuItems(): Collection
    {
        if (Schema::hasTable('bujk_sbu')) {
            $query = DB::table('bujk_sbu');

            if (Schema::hasColumn('bujk_sbu', 'is_deleted')) {
                $query->where('is_deleted', 0);
            }

            return $query
                ->get()
                ->map(function ($row) {
                    return [
                        'id' => $this->publicValue($row, ['id', 'ID']),
                        'nib' => $this->publicValue($row, ['nib', 'NIB']),
                        'nama' => $this->publicValue($row, ['nama_bujk', 'nama', 'Nama_BUJK', 'Nama']),
                        'jenis_usaha' => $this->normalizeJenisBujk(
                            $this->publicValue($row, ['jenis_bujk', 'jenis_usaha', 'jenis', 'Jenis_Usaha'])
                        ),
                        'asosiasi' => $this->publicValue($row, ['asosiasi', 'nama_asosiasi', 'Asosiasi']),
                        'pelaksana' => $this->publicValue($row, ['pelaksana', 'pelaksana_sertifikasi', 'lsbu', 'lembaga_sertifikasi', 'Lembaga_Sertifikasi']),
                        'kbli' => $this->publicValue($row, ['kbli', 'kode_kbli', 'KBLI', 'Kode_KBLI']),
                        'kabupaten' => $this->normalizePublicKabupaten(
                            $this->publicValue($row, ['kab_kota_bujk', 'kabupaten', 'kab_kota', 'kabupaten_kota'])
                        ),
                    ];
                })
                ->filter(fn ($item) => filled($item['nama']) || filled($item['nib']) || filled($item['jenis_usaha']))
                ->values();
        }

        if (Schema::hasTable('sbu')) {
            $query = DB::table('sbu');

            if (Schema::hasColumn('sbu', 'is_deleted')) {
                $query->where('is_deleted', 0);
            }

            return $query
                ->get()
                ->map(function ($row) {
                    return [
                        'id' => $this->publicValue($row, ['id', 'ID']),
                        'nib' => $this->publicValue($row, ['nib', 'NIB']),
                        'nama' => $this->publicValue($row, ['nama_bujk', 'nama', 'Nama_BUJK', 'Nama']),
                        'jenis_usaha' => $this->normalizeJenisBujk(
                            $this->publicValue($row, ['jenis_bujk', 'jenis_usaha', 'jenis', 'Jenis_Usaha'])
                        ),
                        'asosiasi' => $this->publicValue($row, ['asosiasi', 'nama_asosiasi', 'Asosiasi']),
                        'pelaksana' => $this->publicValue($row, ['pelaksana', 'pelaksana_sertifikasi', 'lsbu', 'lembaga_sertifikasi', 'Lembaga_Sertifikasi']),
                        'kbli' => $this->publicValue($row, ['kbli', 'kode_kbli', 'KBLI', 'Kode_KBLI']),
                        'kabupaten' => $this->normalizePublicKabupaten(
                            $this->publicValue($row, ['kab_kota_bujk', 'kabupaten', 'kab_kota', 'kabupaten_kota'])
                        ),
                    ];
                })
                ->filter(fn ($item) => filled($item['nama']) || filled($item['nib']) || filled($item['jenis_usaha']))
                ->values();
        }

        return $this->getPublicBujkItems()
            ->map(function ($item) {
                return array_merge($item, [
                    'pelaksana' => $item['asosiasi'] ?: null,
                    'kbli' => $item['kbli'] ?? null,
                ]);
            })
            ->values();
    }

    private function getPublicBujkItems(): Collection
    {
        if (!Schema::hasTable('bujk')) {
            return collect();
        }

        $query = DB::table('bujk');

        if (Schema::hasColumn('bujk', 'is_deleted')) {
            $query->where('is_deleted', 0);
        }

        return $query
            ->get()
            ->map(function ($row) {
                return [
                    'id' => $this->publicValue($row, ['id', 'ID']),
                    'nib' => $this->publicValue($row, ['nib', 'NIB']),
                    'nama' => $this->publicValue($row, ['nama_bujk', 'nama', 'Nama_BUJK', 'Nama']),
                    'jenis_usaha' => $this->normalizeJenisBujk(
                        $this->publicValue($row, ['jenis_bujk', 'jenis_usaha', 'jenis', 'Jenis_Usaha'])
                    ),
                    'alamat' => $this->publicValue($row, ['alamat_bujk', 'alamat', 'Alamat']),
                    'npwp' => $this->publicValue($row, ['npwp', 'NPWP']),
                    'kabupaten' => $this->normalizePublicKabupaten(
                        $this->publicValue($row, ['kab_kota_bujk', 'kabupaten', 'kab_kota', 'kabupaten_kota'])
                    ),
                    'provinsi' => $this->publicValue($row, ['prov_bujk', 'provinsi', 'Provinsi']) ?: 'Kalimantan Timur',
                    'telepon' => $this->publicValue($row, ['telp_bujk', 'telepon', 'no_telp', 'No_Telp']),
                    'email' => $this->publicValue($row, ['email_bujk', 'email', 'Email']),
                    'website' => $this->publicValue($row, ['website_bujk', 'website', 'Website']),
                    'asosiasi' => $this->publicValue($row, ['asosiasi', 'nama_asosiasi', 'Asosiasi']),
                    'kbli' => $this->publicValue($row, ['kbli', 'kode_kbli', 'KBLI', 'Kode_KBLI']),
                ];
            })
            ->filter(fn ($item) => filled($item['nama']) || filled($item['nib']))
            ->values();
    }

    private function getPublicTkkItems(): Collection
    {
        $table = $this->getTkkTableName();

        if (!$table) {
            return collect();
        }

        return DB::table($table)
            ->get()
            ->map(function ($row) {
                $tanggalKadaluwarsa = $this->publicValue($row, [
                    'Tanggal_Kadaluwarsa',
                    'Tanggal_kadaluwarsa',
                    'tanggal_kadaluwarsa',
                    'tgl_kadaluwarsa',
                    'Tanggal_Masa_Berlaku',
                    'tanggal_masa_berlaku',
                    'masa_berlaku',
                ]);

                return [
                    'id' => $this->publicValue($row, ['id', 'ID']),
                    'nama' => $this->publicValue($row, ['Nama', 'nama', 'name']),
                    'kabupaten' => $this->normalizePublicKabupaten(
                        $this->publicValue($row, ['Kabupaten', 'kabupaten', 'kab_kota', 'kabupaten_kota', 'Kabupaten_Kota'])
                    ),
                    'jenjang' => $this->normalizePublicJenjang(
                        $this->publicValue($row, ['Jenjang', 'jenjang', 'id_kualifikasi', 'kualifikasi'])
                    ),
                    'klasifikasi' => $this->publicValue($row, ['Klasifikasi', 'klasifikasi']),
                    'jabatan_kerja' => $this->publicValue($row, ['Jabatan_Kerja', 'jabatan_kerja', 'jabatan']),
                    'asosiasi' => $this->publicValue($row, ['Asosiasi', 'asosiasi']),
                    'tanggal_kadaluwarsa' => $tanggalKadaluwarsa,
                ];
            })
            ->filter(function ($item) {
                return filled($item['nama'])
                    || filled($item['kabupaten'])
                    || filled($item['jenjang'])
                    || filled($item['asosiasi'])
                    || filled($item['klasifikasi']);
            })
            ->values();
    }

    private function getTkkTableName(): ?string
    {
        if (Schema::hasTable('tkk')) {
            return 'tkk';
        }

        if (Schema::hasTable('tkk_data')) {
            return 'tkk_data';
        }

        return null;
    }

    private function publicValue(object $row, array $columns): mixed
    {
        foreach ($columns as $column) {
            if (property_exists($row, $column)) {
                return $row->{$column};
            }
        }

        return null;
    }

    private function normalizeJenisBujk($value): string
    {
        if (blank($value)) {
            return 'Tidak Diketahui';
        }

        $value = trim((string) $value);
        $lower = strtolower($value);

        $parts = [];

        if (str_contains($lower, 'konstruksi') && !str_contains($lower, 'konsultan')) {
            $parts[] = 'Konstruksi';
        }

        if (str_contains($lower, 'konsultan')) {
            $parts[] = 'Konsultan Konstruksi';
        }

        if (empty($parts)) {
            return $value;
        }

        return implode(' & ', array_unique($parts));
    }

    private function normalizePublicJenjang($value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim((string) $value);

        if (preg_match('/\d+/', $value, $matches)) {
            return $matches[0];
        }

        return $value;
    }

    private function normalizePublicKabupaten($value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim((string) $value);

        $map = [
            '64.01' => 'Kab. Paser',
            '64.02' => 'Kab. Kutai Kartanegara',
            '64.03' => 'Kab. Berau',
            '64.07' => 'Kab. Kutai Barat',
            '64.08' => 'Kab. Kutai Timur',
            '64.09' => 'Kab. Penajam Paser Utara',
            '64.11' => 'Kab. Mahakam Ulu',
            '64.71' => 'Kota Balikpapan',
            '64.72' => 'Kota Samarinda',
            '64.74' => 'Kota Bontang',

            'Paser' => 'Kab. Paser',
            'Kabupaten Paser' => 'Kab. Paser',
            'Kab. Paser' => 'Kab. Paser',

            'Kutai Kartanegara' => 'Kab. Kutai Kartanegara',
            'Kabupaten Kutai Kartanegara' => 'Kab. Kutai Kartanegara',
            'Kab. Kutai Kartanegara' => 'Kab. Kutai Kartanegara',

            'Berau' => 'Kab. Berau',
            'Kabupaten Berau' => 'Kab. Berau',
            'Kab. Berau' => 'Kab. Berau',

            'Kutai Barat' => 'Kab. Kutai Barat',
            'Kabupaten Kutai Barat' => 'Kab. Kutai Barat',
            'Kab. Kutai Barat' => 'Kab. Kutai Barat',

            'Kutai Timur' => 'Kab. Kutai Timur',
            'Kabupaten Kutai Timur' => 'Kab. Kutai Timur',
            'Kab. Kutai Timur' => 'Kab. Kutai Timur',

            'Penajam Paser Utara' => 'Kab. Penajam Paser Utara',
            'Kabupaten Penajam Paser Utara' => 'Kab. Penajam Paser Utara',
            'Kab. Penajam Paser Utara' => 'Kab. Penajam Paser Utara',

            'Mahakam Ulu' => 'Kab. Mahakam Ulu',
            'Kabupaten Mahakam Ulu' => 'Kab. Mahakam Ulu',
            'Kab. Mahakam Ulu' => 'Kab. Mahakam Ulu',

            'Balikpapan' => 'Kota Balikpapan',
            'Kota Balikpapan' => 'Kota Balikpapan',

            'Samarinda' => 'Kota Samarinda',
            'Kota Samarinda' => 'Kota Samarinda',

            'Bontang' => 'Kota Bontang',
            'Kota Bontang' => 'Kota Bontang',
        ];

        return $map[$value] ?? $value;
    }

    private function isSameExpiredYear($date, int $year): bool
    {
        if (blank($date)) {
            return false;
        }

        try {
            return Carbon::parse($date)->year === $year;
        } catch (\Throwable) {
            return false;
        }
    }
}