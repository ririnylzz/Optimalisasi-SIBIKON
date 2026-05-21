<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    public function index()
    {
        $bujkRows = DB::table('bujk')
            ->select(
                'id',
                'id_izin',
                'nib',
                'asosiasi',
                'nama_bujk as nama_bu',
                'bentuk_usaha',
                'propinsi',
                'kab_kota_bujk as kabupaten',
                'jenis_bujk as jenis_usaha',
                'sifat',
                'kbli_bener',
                'kbli_inputan',
                'klasifikasi',
                'kode_subklasifikasi',
                'subklasifikasi',
                'id_kualifikasi',
                'pelaksana_sertifikasi',
                'tanggal_ditetapkan',
                'tanggal_masa_berlaku',
                'valid',
                'status',
                'is_deleted',
                'created_at'
            )
            ->get();

        $activeRows = $bujkRows->where('is_deleted', 0)->values();

        /*
        * Karena tabel bujk sekarang memuat data BUJK + SBU dalam satu tabel,
        * kemungkinan satu BUJK bisa muncul beberapa kali karena punya beberapa SBU.
        * Jadi total BUJK dihitung dari NIB unik.
        */
        $uniqueBujkRows = $activeRows
            ->groupBy(function ($row) {
                if (!empty($row->nib)) {
                    return 'nib:' . $row->nib;
                }

                if (!empty($row->nama_bu)) {
                    return 'nama:' . $row->nama_bu;
                }

                return 'id:' . $row->id;
            })
            ->map(fn($items) => $items->first())
            ->values();

        $totalBujk = $uniqueBujkRows->count();

        /*
        * Total SBU dihitung dari jumlah baris aktif yang punya identitas SBU.
        * Kalau semua kosong, fallback ke jumlah baris aktif.
        */
        $totalSbu = $activeRows
            ->filter(function ($row) {
                return !empty($row->kode_subklasifikasi)
                    || !empty($row->subklasifikasi)
                    || !empty($row->id_kualifikasi)
                    || !empty($row->tanggal_ditetapkan)
                    || !empty($row->tanggal_masa_berlaku);
            })
            ->count();

        if ($totalSbu === 0) {
            $totalSbu = $activeRows->count();
        }

        $countByField = function ($rows, string $field, int $limit = 5) {
            return $rows
                ->map(function ($row) use ($field) {
                    return trim((string) ($row->{$field} ?? ''));
                })
                ->filter(fn($value) => $value !== '')
                ->groupBy(fn($value) => $value)
                ->map(function ($items, $label) {
                    return [
                        'label' => $label,
                        'value' => $items->count(),
                    ];
                })
                ->sortByDesc('value')
                ->take($limit)
                ->values();
        };

        $countByFields = function ($rows, array $fields, int $limit = 5) {
            return $rows
                ->map(function ($row) use ($fields) {
                    foreach ($fields as $field) {
                        $value = trim((string) ($row->{$field} ?? ''));

                        if ($value !== '') {
                            return $value;
                        }
                    }

                    return null;
                })
                ->filter()
                ->groupBy(fn($value) => $value)
                ->map(function ($items, $label) {
                    return [
                        'label' => $label,
                        'value' => $items->count(),
                    ];
                })
                ->sortByDesc('value')
                ->take($limit)
                ->values();
        };

        $countSplitField = function ($rows, string $field, int $limit = 10) {
            $values = collect();

            foreach ($rows as $row) {
                $rawValue = trim((string) ($row->{$field} ?? ''));

                if ($rawValue === '') {
                    continue;
                }

                $parts = preg_split('/[,;|]+/', $rawValue, -1, PREG_SPLIT_NO_EMPTY);

                foreach ($parts as $part) {
                    $clean = trim($part);

                    if ($clean !== '') {
                        $values->push($clean);
                    }
                }
            }

            return $values
                ->groupBy(fn($value) => $value)
                ->map(function ($items, $label) {
                    return [
                        'label' => $label,
                        'value' => $items->count(),
                    ];
                })
                ->sortByDesc('value')
                ->take($limit)
                ->values();
        };

        $jenisBujk = $countSplitField($uniqueBujkRows, 'jenis_usaha', 10);

        $association = $countByField($uniqueBujkRows, 'asosiasi', 5);

        $jenisSbu = $countSplitField($activeRows, 'jenis_usaha', 10);

        $pelaksanaSbu = $countByField($activeRows, 'pelaksana_sertifikasi', 5);

        $kbliSbu = $countByFields($activeRows, [
            'kbli_bener',
            'kbli_inputan',
        ], 5);

        $kualifikasiSbu = $countByField($activeRows, 'id_kualifikasi', 10);

        $subKlasifikasiSbu = $activeRows
            ->map(function ($row) {
                $kode = trim((string) ($row->kode_subklasifikasi ?? ''));
                $subklasifikasi = trim((string) ($row->subklasifikasi ?? ''));

                if ($kode !== '') {
                    return $kode;
                }

                if ($subklasifikasi !== '') {
                    return $subklasifikasi;
                }

                return null;
            })
            ->filter()
            ->groupBy(fn($value) => $value)
            ->map(function ($items, $label) {
                return [
                    'label' => $label,
                    'value' => $items->count(),
                ];
            })
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $sifatSbu = $countByField($activeRows, 'sifat', 10);

        /*
        * Fallback agar chart tidak error kalau ada kolom yang masih kosong.
        * Ini bukan data dummy, hanya label kosong 0 supaya Chart.js tetap aman.
        */
        if ($jenisBujk->isEmpty()) {
            $jenisBujk = collect([
                ['label' => 'Belum Ada Data', 'value' => 0],
            ]);
        }

        if ($association->isEmpty()) {
            $association = collect([
                ['label' => 'Belum Ada Data', 'value' => 0],
            ]);
        }

        if ($jenisSbu->isEmpty()) {
            $jenisSbu = collect([
                ['label' => 'Belum Ada Data', 'value' => 0],
            ]);
        }

        if ($pelaksanaSbu->isEmpty()) {
            $pelaksanaSbu = collect([
                ['label' => 'Belum Ada Data', 'value' => 0],
            ]);
        }

        if ($kbliSbu->isEmpty()) {
            $kbliSbu = collect([
                ['label' => 'Belum Ada Data', 'value' => 0],
            ]);
        }

        if ($kualifikasiSbu->isEmpty()) {
            $kualifikasiSbu = collect([
                ['label' => 'Belum Ada Data', 'value' => 0],
            ]);
        }

        if ($subKlasifikasiSbu->isEmpty()) {
            $subKlasifikasiSbu = collect([
                ['label' => 'Belum Ada Data', 'value' => 0],
            ]);
        }

        if ($sifatSbu->isEmpty()) {
            $sifatSbu = collect([
                ['label' => 'Belum Ada Data', 'value' => 0],
            ]);
        }

        $kpi = [
            [
                'label' => 'BUJK',
                'title' => 'Badan Usaha Jasa Konstruksi',
                'value' => number_format($totalBujk),
            ],
            [
                'label' => 'SBU',
                'title' => 'Sertifikat Badan Usaha',
                'value' => number_format($totalSbu),
            ],
        ];

        return view('admin.dashboard', compact(
            'association',
            'jenisBujk',
            'jenisSbu',
            'pelaksanaSbu',
            'kbliSbu',
            'kualifikasiSbu',
            'subKlasifikasiSbu',
            'sifatSbu',
            'kpi',
        ));
    }

    public function tkk(Request $request)
    {
        $today = Carbon::now()->startOfDay();
        $endOfYear = Carbon::now()->endOfYear();

        $selectedKabupaten = $request->query('kabupaten', 'semua');
        $selectedMode = $request->query('mode', 'semua_skk');
        $selectedJenjang = $request->query('jenjang', [7, 8, 9]);

        if (!is_array($selectedJenjang)) {
            $selectedJenjang = [$selectedJenjang];
        }

        $selectedJenjang = collect($selectedJenjang)
            ->map(fn($item) => (string) $item)
            ->values()
            ->all();

        $search = $request->query('search');
        $searchBy = $request->query('search_by', 'nama');

        if (empty($selectedJenjang)) {
            $selectedJenjang = ['7', '8', '9'];
        }

        $allRows = DB::table('tkk')
            ->select(
                'id',
                'nama',
                'kabupaten',
                'klasifikasi',
                'jabatan_kerja',
                'jenjang',
                'asosiasi',
                'tanggal_aktif',
                'tanggal_kadaluwarsa',
                'created_at'
            )
            ->get();

        $isAktif = function ($row) use ($today) {
            if (!$row->tanggal_aktif || !$row->tanggal_kadaluwarsa) {
                return false;
            }

            $tanggalAktif = Carbon::parse($row->tanggal_aktif)->startOfDay();
            $tanggalKadaluwarsa = Carbon::parse($row->tanggal_kadaluwarsa)->startOfDay();

            return $tanggalAktif->lessThanOrEqualTo($today)
                && $tanggalKadaluwarsa->greaterThanOrEqualTo($today);
        };

        $isKadaluarsaTahunIni = function ($row) use ($today, $endOfYear) {
            if (!$row->tanggal_kadaluwarsa) {
                return false;
            }

            $tanggalKadaluwarsa = Carbon::parse($row->tanggal_kadaluwarsa)->startOfDay();

            return $tanggalKadaluwarsa->betweenIncluded($today, $endOfYear);
        };

        $filteredRows = $allRows->filter(function ($row) use (
            $selectedKabupaten,
            $selectedJenjang,
            $search,
            $searchBy
        ) {
            $matchSearch = true;

            if (!empty($search)) {
                $keyword = strtolower($search);

                if ($searchBy === 'nama') {
                    $matchSearch = str_contains(
                        strtolower($row->nama ?? ''),
                        $keyword
                    );
                } elseif ($searchBy === 'kabupaten') {
                    $matchSearch = str_contains(
                        strtolower($row->kabupaten ?? ''),
                        $keyword
                    );
                } elseif ($searchBy === 'jabatan') {
                    $matchSearch = str_contains(
                        strtolower($row->jabatan_kerja ?? ''),
                        $keyword
                    );
                }
            }
            $matchKabupaten = $selectedKabupaten === 'semua'
                || $selectedKabupaten === ''
                || $row->kabupaten === $selectedKabupaten;

            $matchJenjang = in_array((string) $row->jenjang, $selectedJenjang, true);

            return $matchKabupaten && $matchJenjang && $matchSearch;
        });

        if ($selectedMode === 'aktif') {
            $filteredRows = $filteredRows->filter($isAktif);
        }

        if ($selectedMode === 'kadaluarsa_tahun_ini') {
            $filteredRows = $filteredRows->filter($isKadaluarsaTahunIni);
        }

        $totalTkk = $filteredRows->count();
        $totalSkk = $filteredRows->count();

        $sertifikatAktifTotal = $filteredRows->filter($isAktif)->count();
        $kadaluarsaTahunIni = $filteredRows->filter($isKadaluarsaTahunIni)->count();

        $aktifTidakKadaluarsaTahunIni = max($sertifikatAktifTotal - $kadaluarsaTahunIni, 0);

        $kpi = [
            [
                'label' => 'TKK',
                'title' => 'Tenaga Kerja Konstruksi',
                'value' => number_format($totalTkk),
            ],
            [
                'label' => 'SKK',
                'title' => 'Sertifikat Kompetensi Kerja',
                'value' => number_format($totalSkk),
            ],
            [
                'label' => 'AKTIF',
                'title' => 'Sertifikat Aktif',
                'value' => number_format($sertifikatAktifTotal),
            ],
            [
                'label' => 'EXP',
                'title' => 'Kadaluarsa Tahun Ini',
                'value' => number_format($kadaluarsaTahunIni),
            ],
        ];

        $statusSertifikasi = [
            [
                'label' => 'Aktif',
                'value' => $aktifTidakKadaluarsaTahunIni,
            ],
            [
                'label' => 'Kadaluarsa Akhir Tahun Ini',
                'value' => $kadaluarsaTahunIni,
            ],
        ];

        $distribusiJenjang = collect([7, 8, 9])
            ->map(function ($jenjang) use ($filteredRows) {
                return [
                    'label' => (string) $jenjang,
                    'value' => $filteredRows->where('jenjang', $jenjang)->count(),
                ];
            })
            ->values();

        $topAsosiasi = $filteredRows
            ->filter(fn($row) => !empty($row->asosiasi))
            ->groupBy('asosiasi')
            ->map(function ($items, $label) {
                return [
                    'label' => $label,
                    'value' => $items->count(),
                ];
            })
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $topKlasifikasi = $filteredRows
            ->groupBy(function ($row) {
                return $row->klasifikasi ?: 'Tidak Diketahui';
            })
            ->map(function ($items, $label) {
                return [
                    'label' => $label,
                    'value' => $items->count(),
                ];
            })
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $perbandinganKabupaten = $filteredRows
            ->filter(fn($row) => !empty($row->kabupaten))
            ->groupBy('kabupaten')
            ->map(function ($items, $label) {
                return [
                    'label' => $label,
                    'value' => $items->count(),
                ];
            })
            ->sortByDesc('value')
            ->values();

        $proyeksiKadaluarsa = collect(range(now()->year, now()->year + 5))
            ->map(function ($year) use ($filteredRows) {
                return [
                    'label' => (string) $year,
                    'value' => $filteredRows->filter(function ($row) use ($year) {
                        if (!$row->tanggal_kadaluwarsa) {
                            return false;
                        }

                        return Carbon::parse($row->tanggal_kadaluwarsa)->year === $year;
                    })->count(),
                ];
            })
            ->values();

        $kabupatenOptions = $allRows
            ->pluck('kabupaten')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $tkkRows = $filteredRows
            ->take(10)
            ->map(function ($row) use ($today, $isAktif) {
                $status = 'Belum Aktif';

                if ($isAktif($row)) {
                    $status = 'Aktif';
                } elseif ($row->tanggal_kadaluwarsa && Carbon::parse($row->tanggal_kadaluwarsa)->lt($today)) {
                    $status = 'Kadaluarsa';
                }

                return [
                    'nama' => $row->nama,
                    'kabupaten' => $row->kabupaten,
                    'klasifikasi' => $row->klasifikasi,
                    'jabatan' => $row->jabatan_kerja,
                    'jenjang' => $row->jenjang,
                    'asosiasi' => $row->asosiasi,
                    'tanggal_aktif' => $row->tanggal_aktif,
                    'tanggal_kadaluwarsa' => $row->tanggal_kadaluwarsa,
                    'status' => $status,
                ];
            })
            ->values();

        return view('admin.dashboard-tkk', compact(
            'kpi',
            'statusSertifikasi',
            'distribusiJenjang',
            'topAsosiasi',
            'topKlasifikasi',
            'perbandinganKabupaten',
            'proyeksiKadaluarsa',
            'kabupatenOptions',
            'tkkRows',
            'totalTkk',
            'selectedKabupaten',
            'selectedMode',
            'selectedJenjang'
        ));
    }
    public function searchTkk(Request $request)
    {
        $keyword = strtolower($request->query('keyword', ''));
        $category = $request->query('category', 'nama');
        $page = (int) $request->query('page', 1);

        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $allowedCategories = [
            'nama',
            'kabupaten',
            'jabatan',
        ];

        if (!in_array($category, $allowedCategories)) {
            $category = 'nama';
        }

        $columnMap = [
            'nama' => 'nama',
            'kabupaten' => 'kabupaten',
            'jabatan' => 'jabatan_kerja',
        ];

        $column = $columnMap[$category];

        $query = DB::table('tkk')
            ->select(
                'nama',
                'kabupaten',
                'jabatan_kerja',
                'jenjang',
                'tanggal_aktif',
                'tanggal_kadaluwarsa'
            )
            ->when($keyword, function ($query) use ($column, $keyword) {
                $query->whereRaw("LOWER($column) LIKE ?", ["%{$keyword}%"]);
            });

        $total = $query->count();

        $rows = $query
            ->offset($offset)
            ->limit($perPage)
            ->get();

        $today = Carbon::now()->startOfDay();

        $data = $rows->map(function ($row) use ($today) {

            $status = 'Belum Aktif';

            if ($row->tanggal_aktif && $row->tanggal_kadaluwarsa) {

                $aktif = Carbon::parse($row->tanggal_aktif)->startOfDay();
                $kadaluarsa = Carbon::parse($row->tanggal_kadaluwarsa)->startOfDay();

                if (
                    $aktif->lessThanOrEqualTo($today) &&
                    $kadaluarsa->greaterThanOrEqualTo($today)
                ) {
                    $status = 'Aktif';
                } elseif ($kadaluarsa->lt($today)) {
                    $status = 'Kadaluarsa';
                }
            }

            return [
                'nama' => $row->nama,
                'kabupaten' => $row->kabupaten,
                'jabatan' => $row->jabatan_kerja,
                'jenjang' => $row->jenjang,
                'status' => $status,
            ];
        });

        return response()->json([
            'data' => $data,
            'total' => $total,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
        ]);
    }
}
