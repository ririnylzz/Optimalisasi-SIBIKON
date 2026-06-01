<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tkk;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Throwable;

class DashboardController extends Controller
{
    protected string $latestTkkDataDatePath = 'tkk/latest-data-date.txt';
    public function index()
    {
        $bujkRows = DB::table('bujk')
            ->select(
                'id',
                'id_izin',
                'nib',
                'asosiasi',
                'nama_bu',
                'bentuk_usaha',
                'propinsi',
                'kabupaten',
                'jenis_usaha',
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
            ->map(fn ($items) => $items->first())
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
                ->filter(fn ($value) => $value !== '')
                ->groupBy(fn ($value) => $value)
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
                ->groupBy(fn ($value) => $value)
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
                ->groupBy(fn ($value) => $value)
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
            ->groupBy(fn ($value) => $value)
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

        $latestDataDate = null;

        if (Storage::disk('local')->exists('bujk/latest-data-date.txt')) {
            $latestDataDate = trim(
                Storage::disk('local')->get('bujk/latest-data-date.txt')
            );
        }

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
            'latestDataDate'
        ));
    }

    public function tkk(Request $request)
    {
        $today = Carbon::now()->startOfDay();
        $endOfYear = Carbon::now()->endOfYear();

        $selectedKabupaten = $request->query('kabupaten', 'semua');
        $selectedMode = $request->query('mode', 'semua_skk');
        $selectedTahun = $request->query('tahun', 'semua');
        $selectedAsosiasi = $request->query('asosiasi', 'semua');
        $selectedJenjang = $request->query('jenjang', [7, 8, 9]);

        if (!is_array($selectedJenjang)) {
            $selectedJenjang = [$selectedJenjang];
        }

        $selectedJenjang = collect($selectedJenjang)
            ->map(fn ($item) => (string) $item)
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
            $selectedTahun,
            $selectedAsosiasi,
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

            $matchAsosiasi = $selectedAsosiasi === 'semua'
                || $selectedAsosiasi === ''
                || $row->asosiasi === $selectedAsosiasi;
                
            $matchJenjang = in_array((string) $row->jenjang, $selectedJenjang, true);

            $matchTahun = $selectedTahun === 'semua'
                || $selectedTahun === ''
                || Carbon::parse($row->tanggal_kadaluwarsa)->year === (int) $selectedTahun;

            return $matchKabupaten && $matchAsosiasi && $matchJenjang && $matchSearch && $matchTahun;
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
            ->filter(fn ($row) => !empty($row->asosiasi))
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

                $jabatanList = $items
                    ->pluck('jabatan_kerja')
                    ->filter()
                    ->unique()
                    ->take(5)
                    ->values();

                return [
                    'label' => $label,
                    'value' => $items->count(),
                    'jabatan' => $jabatanList,
                ];
            })
            ->sortByDesc('value')
            ->take(5)
            ->values();

        $perbandinganKabupaten = $filteredRows
            ->filter(fn ($row) => !empty($row->kabupaten))
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

        $tahunOptions = $allRows
            ->filter(fn ($row) => !empty($row->tanggal_kadaluwarsa))
            ->map(function ($row) {
                return Carbon::parse($row->tanggal_kadaluwarsa)->year;
            })
            ->unique()
            ->sort()
            ->values();

        $asosiasiOptions = $allRows
            ->pluck('asosiasi')
            ->filter()
            ->unique()
            ->sort()
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

        $latestDataDate = null;

        if (Storage::disk('local')->exists('bujk/latest-data-date.txt')) {
            $latestDataDate = trim(
                Storage::disk('local')->get('bujk/latest-data-date.txt')
            );
        }

        return view('admin.dashboard-tkk', compact(
            'kpi',
            'statusSertifikasi',
            'distribusiJenjang',
            'topAsosiasi',
            'topKlasifikasi',
            'asosiasiOptions',
            'selectedAsosiasi',
            'perbandinganKabupaten',
            'proyeksiKadaluarsa',
            'kabupatenOptions',
            'tahunOptions',
            'selectedTahun',
            'tkkRows',
            'totalTkk',
            'selectedKabupaten',
            'selectedMode',
            'selectedJenjang',
            'latestDataDate'
        ));
    }

    public function tkkData(Request $request)
    {
        $editingTkk = $request->filled('edit')
            ? Tkk::query()->findOrFail((int) $request->query('edit'))
            : null;

        $rows = Tkk::query()
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $tkkRows = $rows->map(fn ($row) => $this->formatTkkRow($row))->values();

        $totalTkk = Tkk::query()->count();
        $latestDataDate = $this->getLatestTkkDataDate();

        return view('admin.tkk-data', [
            'tkkRows' => $tkkRows,
            'totalTkk' => $totalTkk,
            'editingTkk' => $editingTkk,
            'kabupatenOptions' => $this->kaltimKabupatenOptions(),
            'latestDataDate' => $latestDataDate,
        ]);
    }

    public function searchTkk(Request $request)
    {
        $keyword = trim((string) $request->query('keyword', ''));
        $category = $request->query('category', 'nama');
        $page = max((int) $request->query('page', 1), 1);

        $perPage = 10;

        $columnMap = [
            'nama' => 'nama',
            'kabupaten' => 'kabupaten',
            'jabatan' => 'jabatan_kerja',
        ];

        if (!array_key_exists($category, $columnMap)) {
            $category = 'nama';
        }

        $column = $columnMap[$category];

        $query = Tkk::query();

        if ($keyword !== '') {
            $query->whereRaw('LOWER(' . $column . ') LIKE ?', ['%' . strtolower($keyword) . '%']);
        }

        $total = (clone $query)->count();

        $rows = $query
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->forPage($page, $perPage)
            ->get();

        return response()->json([
            'data' => $rows->map(fn ($row) => $this->formatTkkRow($row))->values(),
            'total' => $total,
            'current_page' => $page,
            'last_page' => max((int) ceil($total / $perPage), 1),
        ]);
    }

    public function storeTkk(Request $request): RedirectResponse
    {
        Tkk::query()->create($this->validateTkkPayload($request));

        return redirect()
            ->route('admin.tenaga-kerja-konstruksi')
            ->with('success', 'Data TKK berhasil ditambahkan.');
    }

    public function updateTkk(Request $request, Tkk $tkk): RedirectResponse
    {
        $tkk->update($this->validateTkkPayload($request));

        return redirect()
            ->route('admin.tenaga-kerja-konstruksi')
            ->with('success', 'Data TKK berhasil diperbarui.');
    }

    public function destroyTkk(Tkk $tkk): RedirectResponse
        {
            $tkk->delete();

            return redirect()
                ->route('admin.tenaga-kerja-konstruksi')
                ->with('success', 'Data TKK berhasil dihapus.');
        }

        public function bulkDestroyTkk(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:tkk,id'],
        ], [
            'ids.required' => 'Pilih minimal satu data TKK.',
            'ids.min' => 'Pilih minimal satu data TKK.',
            'ids.*.exists' => 'Ada data TKK yang tidak ditemukan.',
        ]);

        $ids = collect($validated['ids'])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $affected = Tkk::query()
            ->whereIn('id', $ids)
            ->delete();

        return redirect()
            ->route('admin.tenaga-kerja-konstruksi')
            ->with(
                $affected > 0 ? 'success' : 'error',
                $affected > 0
                    ? $affected . ' data TKK berhasil dihapus.'
                    : 'Tidak ada data TKK yang dihapus.'
            );
    }

    public function destroyAllTkk(): RedirectResponse
    {
        $affected = Tkk::query()->count();

        if ($affected < 1) {
            return redirect()
                ->route('admin.tenaga-kerja-konstruksi')
                ->with('error', 'Tidak ada data TKK untuk dihapus.');
        }

        Tkk::query()->delete();

        return redirect()
            ->route('admin.tenaga-kerja-konstruksi')
            ->with('success', 'Semua data TKK berhasil dihapus (' . $affected . ' data).');
    }

    private function kaltimKabupatenOptions(): array
    {
        return [
            'Berau' => 'Kabupaten Berau',
            'Kutai Barat' => 'Kabupaten Kutai Barat',
            'Kutai Kartanegara' => 'Kabupaten Kutai Kartanegara',
            'Kutai Timur' => 'Kabupaten Kutai Timur',
            'Mahakam Ulu' => 'Kabupaten Mahakam Ulu',
            'Paser' => 'Kabupaten Paser',
            'Penajam Paser Utara' => 'Kabupaten Penajam Paser Utara',
            'Balikpapan' => 'Kota Balikpapan',
            'Bontang' => 'Kota Bontang',
            'Samarinda' => 'Kota Samarinda',
        ];
    }

    public function importTkk(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'file_import' => ['required', 'file', 'mimes:xlsx,xls,csv,txt', 'max:10240'],
            'tanggal_data_terbaru' => ['required', 'date'],
        ], [
            'file_import.required' => 'File import wajib dipilih.',
            'file_import.mimes' => 'Format file harus Excel (.xlsx, .xls) atau CSV.',
            'file_import.max' => 'Ukuran file maksimal 10 MB.',
            'tanggal_data_terbaru.required' => 'Tanggal data terbaru wajib diisi.',
            'tanggal_data_terbaru.date' => 'Tanggal data terbaru tidak valid.',
        ]);

        try {
            $file = $validated['file_import'];

            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, false);

            if (empty($rows)) {
                return redirect()
                    ->back()
                    ->withErrors(['file_import' => 'File import kosong atau tidak dapat dibaca.']);
            }

            $headerRow = $rows[0] ?? [];
            $headerMap = $this->resolveTkkHeaderMap($headerRow);

            $useHeader = count($headerMap) >= 2;

            $positionMap = [
                0 => 'nama',
                1 => 'kabupaten',
                2 => 'klasifikasi',
                3 => 'jabatan_kerja',
                4 => 'jenjang',
                5 => 'asosiasi',
                6 => 'tanggal_aktif',
                7 => 'tanggal_kadaluwarsa',
            ];

            $map = $useHeader ? $headerMap : $positionMap;
            $dataRows = array_slice($rows, 1);

            $imported = 0;
            $skipped = 0;

            foreach ($dataRows as $row) {
                $payload = [];

                foreach ($map as $index => $field) {
                    $payload[$field] = $row[$index] ?? null;
                }

                $payload = [
                    'nama' => $this->cleanTkkText($payload['nama'] ?? null),
                    'kabupaten' => $this->cleanTkkText($payload['kabupaten'] ?? null),
                    'klasifikasi' => $this->cleanTkkText($payload['klasifikasi'] ?? null),
                    'jabatan_kerja' => $this->cleanTkkText($payload['jabatan_kerja'] ?? null),
                    'jenjang' => $this->cleanTkkNumber($payload['jenjang'] ?? null),
                    'asosiasi' => $this->cleanTkkText($payload['asosiasi'] ?? null),
                    'tanggal_aktif' => $this->normalizeTkkDate($payload['tanggal_aktif'] ?? null),
                    'tanggal_kadaluwarsa' => $this->normalizeTkkDate($payload['tanggal_kadaluwarsa'] ?? null),
                ];

                if (blank($payload['nama'])) {
                    $skipped++;
                    continue;
                }

                Tkk::query()->create($payload);
                $imported++;
            }
            $latestDataDate = Carbon::parse($validated['tanggal_data_terbaru'])->toDateString();

            Storage::disk('local')->put($this->latestTkkDataDatePath, $latestDataDate);
        } catch (Throwable $exception) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['file_import' => 'Import gagal: ' . $exception->getMessage()]);
        }

        return redirect()
            ->route('admin.tenaga-kerja-konstruksi')
            ->with('success', "Import TKK selesai. Data masuk: {$imported}. Data dilewati: {$skipped}.");
    }

    private function getLatestTkkDataDate(): ?string
    {
        if (!Storage::disk('local')->exists($this->latestTkkDataDatePath)) {
            return null;
        }

        $date = trim((string) Storage::disk('local')->get($this->latestTkkDataDatePath));

        return $date !== '' ? $date : null;
    }

    private function validateTkkPayload(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kabupaten' => ['nullable', 'string', Rule::in(array_keys($this->kaltimKabupatenOptions()))],
            'klasifikasi' => ['nullable', 'string', 'max:255'],
            'jabatan_kerja' => ['nullable', 'string', 'max:255'],
            'jenjang' => ['nullable', 'integer', 'min:1', 'max:9'],
            'asosiasi' => ['nullable', 'string', 'max:255'],
            'tanggal_aktif' => ['nullable', 'date'],
            'tanggal_kadaluwarsa' => ['nullable', 'date'],
        ], [
            'nama.required' => 'Nama TKK wajib diisi.',
            'kabupaten.in' => 'Kabupaten/Kota harus dipilih dari wilayah Kalimantan Timur.',
            'jenjang.integer' => 'Jenjang harus berupa angka.',
            'tanggal_aktif.date' => 'Tanggal aktif tidak valid.',
            'tanggal_kadaluwarsa.date' => 'Tanggal kadaluwarsa tidak valid.',
        ]);
    }

    private function formatTkkRow($row): array
    {
        $status = $this->resolveTkkStatus($row->tanggal_aktif, $row->tanggal_kadaluwarsa);

        return [
            'id' => $row->id,
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
    }

    private function resolveTkkStatus(?string $tanggalAktif, ?string $tanggalKadaluwarsa): string
    {
        $today = Carbon::now()->startOfDay();

        if ($tanggalAktif && $tanggalKadaluwarsa) {
            $aktif = Carbon::parse($tanggalAktif)->startOfDay();
            $kadaluarsa = Carbon::parse($tanggalKadaluwarsa)->startOfDay();

            if ($aktif->lessThanOrEqualTo($today) && $kadaluarsa->greaterThanOrEqualTo($today)) {
                return 'Aktif';
            }

            if ($kadaluarsa->lt($today)) {
                return 'Kadaluarsa';
            }
        }

        return 'Belum Aktif';
    }

    private function resolveTkkHeaderMap(array $headerRow): array
    {
        $aliases = [
            'nama' => ['nama', 'nama_tkk', 'nama tenaga kerja', 'nama tenaga kerja konstruksi'],
            'kabupaten' => ['kabupaten', 'kabupaten_kota', 'kab kota', 'kab/kota', 'kota'],
            'klasifikasi' => ['klasifikasi', 'klasifikasi skk'],
            'jabatan_kerja' => ['jabatan_kerja', 'jabatan kerja', 'jabatan'],
            'jenjang' => ['jenjang', 'jenjang skk', 'level'],
            'asosiasi' => ['asosiasi', 'asosiasi profesi'],
            'tanggal_aktif' => ['tanggal_aktif', 'tanggal aktif', 'tgl aktif', 'tanggal terbit'],
            'tanggal_kadaluwarsa' => ['tanggal_kadaluwarsa', 'tanggal kadaluwarsa', 'tgl kadaluwarsa', 'masa berlaku', 'berlaku sampai'],
        ];

        $map = [];

        foreach ($headerRow as $index => $header) {
            $normalizedHeader = $this->normalizeTkkHeader($header);

            foreach ($aliases as $field => $fieldAliases) {
                foreach ($fieldAliases as $alias) {
                    if ($normalizedHeader === $this->normalizeTkkHeader($alias)) {
                        $map[$index] = $field;
                        break 2;
                    }
                }
            }
        }

        return $map;
    }

    private function normalizeTkkHeader($value): string
    {
        $value = strtolower(trim((string) $value));
        $value = preg_replace('/[^a-z0-9]+/i', '_', $value);
        return trim((string) $value, '_');
    }

    private function cleanTkkText($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = preg_replace('/\s+/u', ' ', trim((string) $value));

        return $value === '' ? null : $value;
    }

    private function cleanTkkNumber($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (int) preg_replace('/\D/', '', (string) $value);
    }

    private function normalizeTkkDate($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            try {
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (Throwable) {
                return null;
            }
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (Throwable) {
            return null;
        }
    }
}