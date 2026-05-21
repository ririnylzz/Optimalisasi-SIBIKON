<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicDashboardController extends Controller
{
    public function tenagaKerja()
    {
        $kabupatenOptions = [
            'Samarinda',
            'Balikpapan',
            'Bontang',
            'Kutai Kartanegara',
        ];

        $selectedKabupaten = 'semua';
        $selectedMode = 'semua_skk';
        $selectedJenjang = [];

        $statusSertifikasi = collect([
            ['label' => 'Aktif', 'value' => 890],
            ['label' => 'Kadaluarsa', 'value' => 120],
        ]);

        $distribusiJenjang = collect([
            ['label' => 'Jenjang 7', 'value' => 320],
            ['label' => 'Jenjang 8', 'value' => 280],
            ['label' => 'Jenjang 9', 'value' => 150],
        ]);

        $topAsosiasi = collect([
            ['label' => 'Asosiasi A', 'value' => 120],
            ['label' => 'Asosiasi B', 'value' => 95],
        ]);

        $topKlasifikasi = collect([
            ['label' => 'Klasifikasi A', 'value' => 80],
            ['label' => 'Klasifikasi B', 'value' => 65],
        ]);

        $perbandinganKabupaten = collect([
            ['label' => 'Samarinda', 'value' => 300],
            ['label' => 'Balikpapan', 'value' => 250],
        ]);

        $proyeksiKadaluarsa = collect([
            ['label' => 'Jan', 'value' => 20],
            ['label' => 'Feb', 'value' => 35],
        ]);

        $tkkRows = [
            [
                'nama' => 'Budi',
                'kabupaten' => 'Samarinda',
                'jabatan' => 'Site Engineer',
                'jenjang' => 7,
                'status' => 'Aktif',
            ],
        ];

        $totalTkk = count($tkkRows);

        return view('pages.dashboard-tkk-publik', compact(
            'kabupatenOptions',
            'selectedKabupaten',
            'selectedMode',
            'selectedJenjang',
            'statusSertifikasi',
            'distribusiJenjang',
            'topAsosiasi',
            'topKlasifikasi',
            'perbandinganKabupaten',
            'proyeksiKadaluarsa',
            'tkkRows',
            'totalTkk'
        ));
    }

    // DASHBOARD BUJK
    public function bujk()
    {
        $kpi = [
            [
                'label' => 'BUJK',
                'title' => 'Badan Usaha Jasa Konstruksi',
                'value' => 747,
            ],
        ];

        $association = collect([
            ['label' => 'Asosiasi A', 'value' => 120],
            ['label' => 'Asosiasi B', 'value' => 90],
        ]);

        $jenisBujk = collect([
            ['label' => 'Kecil', 'value' => 200],
            ['label' => 'Menengah', 'value' => 120],
        ]);

        return view('pages.dashboard-bujk-publik', compact(
            'kpi',
            'association',
            'jenisBujk'
        ));
    }

    // DASHBOARD SBU
    public function sbu()
    {
        $kpi = [
            [
                'label' => 'SBU',
                'title' => 'Sertifikat Badan Usaha',
                'value' => 172,
            ],
        ];

        $jenisSbu = collect([
            ['label' => 'JK', 'value' => 150],
            ['label' => 'Konsultan', 'value' => 60],
        ]);

        $pelaksanaSbu = collect([
            ['label' => 'LPJK', 'value' => 100],
            ['label' => 'LSBU', 'value' => 80],
        ]);

        $kbliSbu = collect([
            ['label' => '41011', 'value' => 50],
            ['label' => '41012', 'value' => 35],
        ]);

        $kualifikasiSbu = collect([
            ['label' => 'Kecil', 'value' => 90],
            ['label' => 'Menengah', 'value' => 60],
        ]);

        $subKlasifikasiSbu = collect([
            ['label' => 'Bangunan Gedung', 'value' => 100],
            ['label' => 'Jalan', 'value' => 80],
        ]);

        $sifatSbu = collect([
            ['label' => 'Umum', 'value' => 120],
            ['label' => 'Spesialis', 'value' => 50],
        ]);

        return view('pages.dashboard-sbu-publik', compact(
            'kpi',
            'jenisSbu',
            'pelaksanaSbu',
            'kbliSbu',
            'kualifikasiSbu',
            'subKlasifikasiSbu',
            'sifatSbu'
        ));
    }
}