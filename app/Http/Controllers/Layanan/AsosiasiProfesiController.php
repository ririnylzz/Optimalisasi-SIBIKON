<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsosiasiProfesiController extends Controller
{
    protected array $allowedPerPage = [10, 25, 50];

    public function index(Request $request)
    {
        // TAMBAHKAN INI
        $search = strtolower(trim($request->query('search', '')));

        // TAMBAHKAN INI
        $perPage = (int) $request->query('per_page', 10);

        if (!in_array($perPage, $this->allowedPerPage)) {
            $perPage = 10;
        }

        // collect()
        $asosiasiProfesi = collect([
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
        ]);

        // FILTER SEARCH
        if ($search !== '') {
            $asosiasiProfesi = $asosiasiProfesi->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['nama_asosiasi']), $search)
                    || str_contains(strtolower($item['singkatan']), $search)
                    || str_contains(strtolower($item['alamat']), $search)
                    || str_contains(strtolower($item['telepon']), $search)
                    || str_contains(strtolower($item['email']), $search);
            });
        }

        // LIMIT DATA
        $asosiasiProfesi = $asosiasiProfesi->take($perPage);

        return view('pages.layanan.asosiasi-profesi', [
            'asosiasiProfesi' => $asosiasiProfesi,
            'allowedPerPage' => $this->allowedPerPage,
            'perPage' => $perPage,
            'search' => $request->query('search', ''),
        ]);
    }
}