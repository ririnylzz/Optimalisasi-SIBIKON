<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;

class AsosiasiProfesiController extends Controller
{
    public function index()
    {
        $asosiasiProfesi = [
            [
                'nama_asosiasi' => 'Ikatan Arsitek Indonesia',
                'singkatan' => 'IAI',
                'alamat' => 'Jl. Ahmad Yani No. 12 Samarinda',
                'telepon' => '(0541) 112233',
                'email' => 'iai@gmail.com',
            ],
            [
                'nama_asosiasi' => 'Persatuan Insinyur Indonesia',
                'singkatan' => 'PII',
                'alamat' => 'Jl. Juanda No. 88 Samarinda',
                'telepon' => '(0541) 223344',
                'email' => 'pii@yahoo.com',
            ],
            [
                'nama_asosiasi' => 'Himpunan Ahli Konstruksi Indonesia',
                'singkatan' => 'HAKI',
                'alamat' => 'Jl. MT Haryono No. 20 Samarinda',
                'telepon' => '(0541) 556677',
                'email' => 'haki@gmail.com',
            ],
        ];

        return view('pages.layanan.asosiasi-profesi', compact('asosiasiProfesi'));
    }
}