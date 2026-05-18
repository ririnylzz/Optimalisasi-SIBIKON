<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AsosiasiPerusahaanController extends Controller
{
    protected array $allowedPerPage = [10, 25, 50];

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);

        if (! in_array($perPage, $this->allowedPerPage, true)) {
            $perPage = 10;
        }

        $search = strtolower(trim($request->query('search', '')));

        $asosiasiPerusahaan = collect([
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
        ]);

        // FILTER SEARCH
        if ($search !== '') {
            $asosiasiPerusahaan = $asosiasiPerusahaan->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['nama_asosiasi']), $search)
                    || str_contains(strtolower($item['singkatan']), $search)
                    || str_contains(strtolower($item['alamat']), $search)
                    || str_contains(strtolower($item['telepon']), $search)
                    || str_contains(strtolower($item['email']), $search);
            });
        }

        // LIMIT DATA
        $asosiasiPerusahaan = $asosiasiPerusahaan->take($perPage);

        return view('pages.layanan.asosiasi-perusahaan', [
            'asosiasiPerusahaan' => $asosiasiPerusahaan,
            'allowedPerPage' => $this->allowedPerPage,
            'perPage' => $perPage,
            'search' => $request->query('search', ''),
        ]);
    }
}