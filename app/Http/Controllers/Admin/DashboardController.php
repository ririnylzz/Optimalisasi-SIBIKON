<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $bujkRows = DB::table('bujk')
            ->select('id', 'nib', 'nama_bujk', 'jenis_bujk', 'kab_kota_bujk', 'provinsi_bujk', 'is_deleted', 'created_at')
            ->get();

        $activeRows = $bujkRows->where('is_deleted', 0);

        $totalBujk = $bujkRows->count();
        $activeBujk = $activeRows->count();
        $nonActiveBujk = $bujkRows->where('is_deleted', 1)->count();

        $duplicateNib = $activeRows
            ->whereNotNull('nib')
            ->groupBy('nib')
            ->filter(fn ($items) => $items->count() > 1)
            ->count();

        $konstruksiCount = $activeRows->filter(fn ($row) => str_contains(strtolower($row->jenis_bujk ?? ''), 'konstruksi'))->count();
        $konsultanCount = $activeRows->filter(fn ($row) => str_contains(strtolower($row->jenis_bujk ?? ''), 'konsultan'))->count();

        $bujkStats = [
            [
                'title' => 'BUJK',
                'value' => number_format($totalBujk),
                'description' => 'Badan Usaha Jasa Konstruksi',
                'accent' => 'bg-[#C5CAE9] text-[#21325E]',
            ],
            [
                'title' => 'Data Aktif',
                'value' => number_format($activeBujk),
                'description' => 'Data BUJK aktif',
                'accent' => 'bg-sky-100 text-sky-600',
            ],
            [
                'title' => 'Duplicate NIB',
                'value' => number_format($duplicateNib),
                'description' => 'NIB terindikasi duplikat',
                'accent' => 'bg-[#F7E578] text-[#8A6A00]',
            ],
            [
                'title' => 'Data Nonaktif',
                'value' => number_format($nonActiveBujk),
                'description' => 'Data terhapus / nonaktif',
                'accent' => 'bg-indigo-100 text-[#3A4FAC]',
            ],
        ];

        $months = collect(range(5, 0))->map(function ($i) {
            return Carbon::now()->subMonths($i);
        });

        $registrationChart = [
            'labels' => $months->map(fn ($month) => $month->translatedFormat('M y'))->values(),
            'values' => $months->map(function ($month) use ($activeRows) {
                return $activeRows->filter(function ($row) use ($month) {
                    if (!$row->created_at) return false;
                    return Carbon::parse($row->created_at)->format('Y-m') === $month->format('Y-m');
                })->count();
            })->values(),
        ];

        $jenisBujk = [
            ['label' => 'Konstruksi', 'value' => $konstruksiCount],
            ['label' => 'Konsultan Konstruksi', 'value' => $konsultanCount],
            ['label' => 'Terintegrasi', 'value' => 0],
        ];

        // Data dummy untuk visualisasi tambahan, nanti bisa diganti kalau tabel SBU/asosiasi sudah tersedia.
        $association = [
            ['label' => 'ASPEKNAS', 'value' => 26252],
            ['label' => 'GAPENSI', 'value' => 17094],
            ['label' => 'P3IM', 'value' => 11553],
            ['label' => 'PPKIN', 'value' => 6994],
            ['label' => 'GAPEKNAS', 'value' => 6139],
        ];

        $jenisSbu = [
            ['label' => 'Pekerjaan Konstruksi', 'value' => 309503],
            ['label' => 'Jasa Konsultasi Konstruksi', 'value' => 32882],
            ['label' => 'Terintegrasi', 'value' => 451],
        ];

        $pelaksanaSbu = [
            ['label' => 'ASPEKNAS', 'value' => 87455],
            ['label' => 'Garmana', 'value' => 59758],
            ['label' => 'PT. SER', 'value' => 41145],
            ['label' => 'LSBU G', 'value' => 32085],
            ['label' => 'PT. HIMJ', 'value' => 22238],
        ];

        $kbliSbu = [
            ['label' => '42101', 'value' => 47218],
            ['label' => '41019', 'value' => 42857],
            ['label' => '41016', 'value' => 42285],
            ['label' => '42201', 'value' => 32971],
            ['label' => '41015', 'value' => 26792],
        ];

        $kualifikasiSbu = [
            ['label' => 'Kecil', 'value' => 313496],
            ['label' => 'Menengah', 'value' => 11790],
            ['label' => 'Besar', 'value' => 4285],
        ];

        $subKlasifikasiSbu = [
            ['label' => 'Konstruksi Gedung', 'value' => 47218],
            ['label' => 'Konstruksi Sipil', 'value' => 42857],
            ['label' => 'Mekanikal', 'value' => 42285],
            ['label' => 'Elektrikal', 'value' => 32971],
            ['label' => 'Lainnya', 'value' => 26792],
        ];

        $sifatSbu = [
            ['label' => 'Umum', 'value' => 329120],
            ['label' => 'Spesialis', 'value' => 13265],
            ['label' => 'Terintegrasi', 'value' => 451],
        ];

        $kpi = [
            [
                'label' => 'BUJK',
                'title' => 'Badan Usaha Jasa Konstruksi',
                'value' => number_format($totalBujk),
            ],
            [
                'label' => 'SBU',
                'title' => 'Sertifikat Badan Usaha',
                'value' => number_format(342836),
            ],
        ];

        $latestBujk = DB::table('bujk')
            ->where('is_deleted', 0)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'association',
            'jenisBujk',
            'jenisSbu',
            'pelaksanaSbu',
            'kbliSbu',
            'kualifikasiSbu',
            'subKlasifikasiSbu',
            'sifatSbu',
            'kpi'
        ));
    }

    public function tkk()
    {
        // KPI (dummy dulu)
        $kpi = [
            [
                'label' => 'TKK',
                'title' => 'Tenaga Kerja Konstruksi',
                'value' => number_format(555505),
            ],
            [
                'label' => 'SKK',
                'title' => 'Sertifikat Kompetensi Kerja',
                'value' => number_format(736921),
            ],
        ];

        // Dummy chart (ambil dari gambar kamu)
        $asosiasiTkk = [
            ['label' => 'ASTEKINDO', 'value' => 147066],
            ['label' => 'PERTAMA', 'value' => 101887],
            ['label' => 'PERKONI', 'value' => 77828],
            ['label' => 'NON ASOSIASI', 'value' => 65346],
            ['label' => 'GATAKI', 'value' => 47369],
        ];

        $kualifikasiSkk = [
            ['label' => 'Ahli', 'value' => 53661],
            ['label' => 'Teknisi/Analis', 'value' => 113670],
            ['label' => 'Operator', 'value' => 80711],
        ];

        $jabkerSkk = [
            ['label' => 'Manajer Lapangan', 'value' => 44098],
            ['label' => 'Pelaksana', 'value' => 36402],
            ['label' => 'Pengawas', 'value' => 32113],
        ];

        return view('admin.dashboard-tkk', compact(
            'kpi',
            'asosiasiTkk',
            'kualifikasiSkk',
            'jabkerSkk'
        ));
    }
}