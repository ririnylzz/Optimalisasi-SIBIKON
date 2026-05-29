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
            ->filter(fn($item) => in_array((string) $item['jenjang'], ['7', '8', '9'], true))
            ->values();

        $totalTkk = $items->count();

        $totalWilayah = $items
            ->pluck('kabupaten')
            ->filter()
            ->unique()
            ->count();

        $distribusiJenjang = $items
            ->filter(fn($item) => filled($item['jenjang']))
            ->groupBy('jenjang')
            ->map(fn($group, $jenjang) => [
                'label' => 'Jenjang ' . $jenjang,
                'value' => $group->count(),
                'raw_label' => (string) $jenjang,
            ])
            ->sortBy(fn($item) => (int) $item['raw_label'])
            ->map(fn($item) => [
                'label' => $item['label'],
                'value' => $item['value'],
            ])
            ->values();

        $topAsosiasi = $items
            ->filter(fn($item) => filled($item['asosiasi']))
            ->groupBy('asosiasi')
            ->map(fn($group, $asosiasi) => [
                'label' => $asosiasi,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $topKlasifikasi = $items
            ->filter(fn($item) => filled($item['klasifikasi']))
            ->groupBy('klasifikasi')
            ->map(fn($group, $klasifikasi) => [
                'label' => $klasifikasi,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $perbandinganKabupaten = $items
            ->filter(fn($item) => filled($item['kabupaten']))
            ->groupBy('kabupaten')
            ->map(fn($group, $kabupaten) => [
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
                        ->filter(fn($item) => $this->isSameExpiredYear($item['tanggal_kadaluwarsa'], $year))
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

    public function tkkAktif()
    {
        $items = $this->getPublicTkkItems()
            ->filter(function ($item) {
                if (blank($item['tanggal_kadaluwarsa'])) {
                    return false;
                }

                try {
                    return Carbon::parse($item['tanggal_kadaluwarsa'])->isFuture();
                } catch (\Throwable) {
                    return false;
                }
            })
            ->values();

        $totalTkkAktif = $items->count();

        $totalWilayah = $items
            ->pluck('kabupaten')
            ->filter()
            ->unique()
            ->count();

        $distribusiJenjang = $items
            ->filter(fn($item) => filled($item['jenjang']))
            ->groupBy('jenjang')
            ->map(fn($group, $jenjang) => [
                'label' => 'Jenjang ' . $jenjang,
                'value' => $group->count(),
                'raw_label' => (string) $jenjang,
            ])
            ->sortBy(fn($item) => (int) $item['raw_label'])
            ->map(fn($item) => [
                'label' => $item['label'],
                'value' => $item['value'],
            ])
            ->values();

        $statusSertifikat = collect([
            [
                'label' => 'Aktif',
                'value' => $items->count(),
            ],
            [
                'label' => 'Kadaluarsa Tahun Ini',
                'value' => $this->getPublicTkkItems()
                    ->filter(function ($item) {
                        if (blank($item['tanggal_kadaluwarsa'])) {
                            return false;
                        }

                        try {
                            return Carbon::parse($item['tanggal_kadaluwarsa'])->year === now()->year
                                && Carbon::parse($item['tanggal_kadaluwarsa'])->isPast();
                        } catch (\Throwable) {
                            return false;
                        }
                    })
                    ->count(),
            ],
        ]);

        $topKabupaten = $items
            ->filter(fn($item) => filled($item['kabupaten']))
            ->groupBy('kabupaten')
            ->map(fn($group, $kabupaten) => [
                'label' => $kabupaten,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->values();

        $topKlasifikasi = $items
            ->filter(fn($item) => filled($item['klasifikasi']))
            ->groupBy('klasifikasi')
            ->map(fn($group, $klasifikasi) => [
                'label' => $klasifikasi,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $proyeksiKadaluarsa = collect(range(0, 5))
            ->map(function ($yearOffset) use ($items) {
                $year = now()->year + $yearOffset;

                return [
                    'label' => (string) $year,
                    'value' => $items
                        ->filter(fn($item) => $this->isSameExpiredYear(
                            $item['tanggal_kadaluwarsa'],
                            $year
                        ))
                        ->count(),
                ];
            })
            ->values();

        return view('pages.dashboard-tkk-aktif-publik', [
            'totalTkkAktif' => $totalTkkAktif,
            'totalWilayah' => $totalWilayah,
            'distribusiJenjang' => $distribusiJenjang,
            'statusSertifikat' => $statusSertifikat,
            'topKabupaten' => $topKabupaten,
            'topKlasifikasi' => $topKlasifikasi,
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
            ->filter(fn($item) => $item['jenis_usaha'] === 'Konstruksi')
            ->count();

        $totalKonsultan = $items
            ->filter(fn($item) => $item['jenis_usaha'] === 'Konsultan Konstruksi')
            ->count();

        $totalKontak = $items
            ->filter(fn($item) => filled($item['telepon']) || filled($item['email']) || filled($item['website']))
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
            ->filter(fn($item) => filled($item['jenis_usaha']))
            ->groupBy('jenis_usaha')
            ->map(fn($group, $jenisUsaha) => [
                'label' => $jenisUsaha,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->values();

        $kabupatenSummary = $items
            ->filter(fn($item) => filled($item['kabupaten']))
            ->groupBy('kabupaten')
            ->map(fn($group, $kabupaten) => [
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
            ->take(5)
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
            ->filter(fn($item) => $item['jenis_usaha'] === 'Konstruksi')
            ->count();

        $totalKonsultan = $items
            ->filter(fn($item) => $item['jenis_usaha'] === 'Konsultan Konstruksi')
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
            ->filter(fn($item) => filled($item['jenis_usaha']))
            ->groupBy('jenis_usaha')
            ->map(fn($group, $jenisUsaha) => [
                'label' => $jenisUsaha,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->values();

        $kabupatenSummary = $items
            ->filter(fn($item) => filled($item['kabupaten']))
            ->groupBy('kabupaten')
            ->map(fn($group, $kabupaten) => [
                'label' => $kabupaten,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->values();

        $asosiasiSummary = $items
            ->filter(fn($item) => filled($item['asosiasi']))
            ->groupBy('asosiasi')
            ->map(fn($group, $asosiasi) => [
                'label' => $asosiasi,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $pelaksanaSummary = $items
            ->filter(fn($item) => filled($item['pelaksana']))
            ->groupBy('pelaksana')
            ->map(fn($group, $pelaksana) => [
                'label' => $pelaksana,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $kbliSummary = $items
            ->filter(fn($item) => filled($item['kbli']))
            ->groupBy('kbli')
            ->map(fn($group, $kbli) => [
                'label' => $kbli,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $kualifikasiSummary = $items
            ->filter(fn($item) => filled($item['kualifikasi']))
            ->groupBy('kualifikasi')
            ->map(fn($group, $kualifikasi) => [
                'label' => $kualifikasi,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->values();

        $subKlasifikasiSummary = $items
            ->filter(fn($item) => filled($item['sub_klasifikasi']))
            ->groupBy('sub_klasifikasi')
            ->map(fn($group, $subKlasifikasi) => [
                'label' => $subKlasifikasi,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $sifatSummary = $items
            ->filter(fn($item) => filled($item['sifat']))
            ->groupBy('sifat')
            ->map(fn($group, $sifat) => [
                'label' => $sifat,
                'value' => $group->count(),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $latestSbu = $items
            ->sortByDesc('id')
            ->take(5)
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
            'kualifikasiSummary' => $kualifikasiSummary,
            'subKlasifikasiSummary' => $subKlasifikasiSummary,
            'sifatSummary' => $sifatSummary,
            'latestSbu' => $latestSbu,
        ]);
    }

    private function getPublicSbuItems(): Collection
    {
        $table = $this->getSbuSourceTable();

        if (!$table) {
            return collect();
        }

        $query = DB::table($table);

        if (Schema::hasColumn($table, 'is_deleted')) {
            $query->where('is_deleted', 0);
        }

        return $query
            ->get()
            ->map(function ($row) {
                return [
                    'id' => $this->publicValue($row, ['id', 'ID']),
                    'nib' => $this->publicValueSmart($row, ['nib']),
                    'nama' => $this->publicValueSmart($row, ['nama_bujk', 'nama', 'nama_badan_usaha']),
                    'jenis_usaha' => $this->normalizeJenisBujk(
                        $this->publicValueSmart($row, ['jenis_usaha', 'jenis_bujk', 'jenis'])
                    ),
                    'asosiasi' => $this->publicValueSmart($row, ['asosiasi', 'asosiasi_bujk', 'nama_asosiasi']),
                    'pelaksana' => $this->publicValueSmart($row, [
                        'pelaksana_sertifikasi',
                        'pelaksana',
                        'lsbu',
                        'nama_lsbu',
                        'lembaga_sertifikasi',
                        'lembaga_sertifikasi_badan_usaha',
                    ]),
                    'kbli' => $this->publicValueSmart($row, ['kbli', 'kode_kbli']),
                    'kualifikasi' => $this->normalizeKualifikasiSbu(
                        $this->publicValueSmart($row, ['kualifikasi_sbu', 'kualifikasi', 'grade'])
                    ),
                    'sub_klasifikasi' => $this->publicValueSmart($row, [
                        'sub_klasifikasi_sbu',
                        'sub_klasifikasi',
                        'subklasifikasi',
                        'kode_sub_klasifikasi',
                        'kode_subklasifikasi',
                        'subklas',
                    ]),
                    'sifat' => $this->publicValueSmart($row, ['sifat_sbu', 'sifat_usaha', 'sifat']),
                    'kabupaten' => $this->normalizePublicKabupaten(
                        $this->publicValueSmart($row, ['kab_kota_bujk', 'kabupaten_kota', 'kab_kota', 'kabupaten', 'kota'])
                    ),
                ];
            })
            ->filter(fn($item) => filled($item['nama']) || filled($item['nib']) || filled($item['jenis_usaha']))
            ->values();
    }

    private function getSbuSourceTable(): ?string
    {
        $candidateTables = [
            'bujk_sbu',
            'sbu',
            'bujk',
        ];

        foreach ($candidateTables as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            $query = DB::table($table);

            if (Schema::hasColumn($table, 'is_deleted')) {
                $query->where('is_deleted', 0);
            }

            if ($query->count() > 0) {
                return $table;
            }
        }

        return null;
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
                    'nib' => $this->publicValueSmart($row, ['nib']),
                    'nama' => $this->publicValueSmart($row, ['nama_bujk', 'nama', 'nama_badan_usaha']),
                    'jenis_usaha' => $this->normalizeJenisBujk(
                        $this->publicValueSmart($row, ['jenis_usaha', 'jenis_bujk', 'jenis'])
                    ),
                    'alamat' => $this->publicValueSmart($row, ['alamat_bujk', 'alamat']),
                    'npwp' => $this->publicValueSmart($row, ['npwp']),
                    'kabupaten' => $this->normalizePublicKabupaten(
                        $this->publicValueSmart($row, ['kab_kota_bujk', 'kabupaten_kota', 'kab_kota', 'kabupaten', 'kota'])
                    ),
                    'provinsi' => $this->publicValueSmart($row, ['prov_bujk', 'provinsi']) ?: 'Kalimantan Timur',
                    'telepon' => $this->publicValueSmart($row, ['telp_bujk', 'telepon', 'no_telp', 'nomor_telepon']),
                    'email' => $this->publicValueSmart($row, ['email_bujk', 'email']),
                    'website' => $this->publicValueSmart($row, ['website_bujk', 'website']),
                    'asosiasi' => $this->publicValueSmart($row, ['asosiasi', 'asosiasi_bujk', 'nama_asosiasi']),
                    'kbli' => $this->publicValueSmart($row, ['kbli', 'kode_kbli']),
                ];
            })
            ->filter(fn($item) => filled($item['nama']) || filled($item['nib']))
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
                $tanggalKadaluwarsa = $this->publicValueSmart($row, [
                    'tanggal_kadaluwarsa',
                    'tgl_kadaluwarsa',
                    'tanggal_masa_berlaku',
                    'masa_berlaku',
                ]);

                return [
                    'id' => $this->publicValue($row, ['id', 'ID']),
                    'nama' => $this->publicValueSmart($row, ['nama', 'name']),
                    'kabupaten' => $this->normalizePublicKabupaten(
                        $this->publicValueSmart($row, ['kabupaten_kota', 'kab_kota', 'kabupaten', 'kota'])
                    ),
                    'jenjang' => $this->normalizePublicJenjang(
                        $this->publicValueSmart($row, ['jenjang', 'id_kualifikasi', 'kualifikasi'])
                    ),
                    'klasifikasi' => $this->publicValueSmart($row, ['klasifikasi']),
                    'jabatan_kerja' => $this->publicValueSmart($row, ['jabatan_kerja', 'jabatan']),
                    'asosiasi' => $this->publicValueSmart($row, ['asosiasi']),
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

    private function publicValueSmart(object $row, array $keys): mixed
    {
        $vars = get_object_vars($row);

        foreach ($keys as $key) {
            foreach ($vars as $column => $value) {
                if (strtolower($column) === strtolower($key) && filled($value)) {
                    return $value;
                }
            }
        }

        foreach ($keys as $key) {
            foreach ($vars as $column => $value) {
                $normalizedColumn = strtolower(str_replace([' ', '-', '/'], '_', $column));
                $normalizedKey = strtolower(str_replace([' ', '-', '/'], '_', $key));

                if (str_contains($normalizedColumn, $normalizedKey) && filled($value)) {
                    return $value;
                }
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

        if (str_contains($lower, 'konsultan')) {
            return 'Konsultan Konstruksi';
        }

        if (str_contains($lower, 'konstruksi')) {
            return 'Konstruksi';
        }

        return $value;
    }

    private function normalizeKualifikasiSbu($value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim((string) $value);
        $upper = strtoupper($value);

        if (in_array($upper, ['K', 'KECIL'], true)) {
            return 'K';
        }

        if (in_array($upper, ['M', 'MENENGAH'], true)) {
            return 'M';
        }

        if (in_array($upper, ['B', 'BESAR'], true)) {
            return 'B';
        }

        if (str_contains(strtolower($value), 'spesialis')) {
            return 'Spesialis';
        }

        return $value;
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
        $upperValue = strtoupper($value);

        $map = [
            '64.01' => 'KABUPATEN PASER',
            '64.02' => 'KABUPATEN KUTAI KARTANEGARA',
            '64.03' => 'KABUPATEN BERAU',
            '64.07' => 'KABUPATEN KUTAI BARAT',
            '64.08' => 'KABUPATEN KUTAI TIMUR',
            '64.09' => 'KABUPATEN PENAJAM PASER UTARA',
            '64.11' => 'KABUPATEN MAHAKAM ULU',
            '64.71' => 'KOTA BALIKPAPAN',
            '64.72' => 'KOTA SAMARINDA',
            '64.74' => 'KOTA BONTANG',

            'PASER' => 'KABUPATEN PASER',
            'KAB. PASER' => 'KABUPATEN PASER',
            'KABUPATEN PASER' => 'KABUPATEN PASER',

            'KUTAI KARTANEGARA' => 'KABUPATEN KUTAI KARTANEGARA',
            'KAB. KUTAI KARTANEGARA' => 'KABUPATEN KUTAI KARTANEGARA',
            'KABUPATEN KUTAI KARTANEGARA' => 'KABUPATEN KUTAI KARTANEGARA',

            'BERAU' => 'KABUPATEN BERAU',
            'KAB. BERAU' => 'KABUPATEN BERAU',
            'KABUPATEN BERAU' => 'KABUPATEN BERAU',

            'KUTAI BARAT' => 'KABUPATEN KUTAI BARAT',
            'KAB. KUTAI BARAT' => 'KABUPATEN KUTAI BARAT',
            'KABUPATEN KUTAI BARAT' => 'KABUPATEN KUTAI BARAT',

            'KUTAI TIMUR' => 'KABUPATEN KUTAI TIMUR',
            'KAB. KUTAI TIMUR' => 'KABUPATEN KUTAI TIMUR',
            'KABUPATEN KUTAI TIMUR' => 'KABUPATEN KUTAI TIMUR',

            'PENAJAM PASER UTARA' => 'KABUPATEN PENAJAM PASER UTARA',
            'KAB. PENAJAM PASER UTARA' => 'KABUPATEN PENAJAM PASER UTARA',
            'KABUPATEN PENAJAM PASER UTARA' => 'KABUPATEN PENAJAM PASER UTARA',

            'MAHAKAM ULU' => 'KABUPATEN MAHAKAM ULU',
            'KAB. MAHAKAM ULU' => 'KABUPATEN MAHAKAM ULU',
            'KABUPATEN MAHAKAM ULU' => 'KABUPATEN MAHAKAM ULU',

            'BALIKPAPAN' => 'KOTA BALIKPAPAN',
            'KOTA BALIKPAPAN' => 'KOTA BALIKPAPAN',

            'SAMARINDA' => 'KOTA SAMARINDA',
            'KOTA SAMARINDA' => 'KOTA SAMARINDA',

            'BONTANG' => 'KOTA BONTANG',
            'KOTA BONTANG' => 'KOTA BONTANG',
        ];

        return $map[$upperValue] ?? $upperValue;
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
