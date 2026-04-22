<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Dummy data sementara, nanti ganti dengan query database asli
        $stats = [
            [
                'title' => 'Total Pengguna',
                'value' => 128,
                'description' => 'Admin, operator, dan user aktif',
                'icon' => 'users',
                'trend' => '+12 bulan ini',
            ],
            [
                'title' => 'Data Pegawai',
                'value' => 342,
                'description' => 'Total pegawai terdaftar',
                'icon' => 'briefcase',
                'trend' => '+18 data baru',
            ],
            [
                'title' => 'Paket Konstruksi',
                'value' => 74,
                'description' => 'Paket aktif tahun berjalan',
                'icon' => 'folder',
                'trend' => '+6 minggu ini',
            ],
            [
                'title' => 'File Upload',
                'value' => 96,
                'description' => 'Upload dokumen terakhir',
                'icon' => 'upload',
                'trend' => '+21 hari ini',
            ],
        ];

        $latestActivities = [
            [
                'title' => 'Import data masyarakat jasa konstruksi',
                'meta' => 'oleh Admin Utama',
                'time' => '10 menit lalu',
                'status' => 'Sukses',
            ],
            [
                'title' => 'Multiple delete pada data pegawai',
                'meta' => 'oleh Operator Dashboard',
                'time' => '32 menit lalu',
                'status' => 'Diproses',
            ],
            [
                'title' => 'Validasi data upload file',
                'meta' => 'oleh Sistem',
                'time' => '1 jam lalu',
                'status' => 'Sukses',
            ],
            [
                'title' => 'Deteksi duplikat NIB & alamat',
                'meta' => 'oleh Sistem',
                'time' => '2 jam lalu',
                'status' => 'Ditemukan 4 data',
            ],
        ];

        $summary = [
            'duplicate_nib' => 4,
            'duplicate_alamat' => 7,
            'pending_verification' => 15,
            'total_berita' => 23,
            'total_kategori' => 8,
            'total_buku_tamu' => 19,
        ];

        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'uploads' => [12, 19, 15, 22, 28, 31],
            'users' => [5, 8, 7, 10, 13, 16],
        ];

        return view('admin.dashboard', compact(
            'stats',
            'latestActivities',
            'summary',
            'chartData'
        ));
    }
}