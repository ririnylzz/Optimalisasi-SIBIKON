<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;

class AsosiasiPerusahaanController extends Controller
{
    public function index()
    {
        $asosiasiPerusahaan = [
            [
                'nama_asosiasi' => 'Gabungan Pelaksana Konstruksi Nasional Indonesia',
                'singkatan' => 'GAPENSI',
                'alamat' => 'Jl. KH Wahid Hasyim No. 45 Samarinda',
                'telepon' => '(0541) 123456',
                'email' => 'gapensi@samarinda.id',
            ],
            [
                'nama_asosiasi' => 'Gabungan Perusahaan Konstruksi Nasional',
                'singkatan' => 'GAPEKSINDO',
                'alamat' => 'Jl. Pahlawan No. 10 Samarinda',
                'telepon' => '(0541) 654321',
                'email' => 'gapeksindo@gmail.com',
            ],
            [
                'nama_asosiasi' => 'Asosiasi Kontraktor Indonesia',
                'singkatan' => 'AKI',
                'alamat' => 'Jl. Juanda No. 88 Samarinda',
                'telepon' => '(0541) 998877',
                'email' => 'aki@yahoo.com',
            ],
        ];

        return view('pages.layanan.asosiasi-perusahaan', compact('asosiasiPerusahaan'));
    }
}