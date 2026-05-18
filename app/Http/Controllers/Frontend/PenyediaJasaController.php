<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Bujk;
use Illuminate\Http\Request;

class PenyediaJasaController extends Controller
{
    public function index(Request $request)
    {
        $allowedPerPage = [10, 25, 50];

        $perPage = (int) $request->query('per_page', 10);

        if (! in_array($perPage, $allowedPerPage, true)) {
            $perPage = 10;
        }

        $search = trim((string) $request->query('search', ''));

        $penyediaJasaKonstruksi = Bujk::query()
            ->where('is_deleted', false)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('nama_bu', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%')
                        ->orWhere('telepon', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->orderByRaw("CASE WHEN nama_bu IS NULL OR nama_bu = '' THEN 1 ELSE 0 END")
            ->orderBy('nama_bu')
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.layanan.penyedia-jasa', [
            'penyediaJasaKonstruksi' => $penyediaJasaKonstruksi,
            'allowedPerPage' => $allowedPerPage,
            'perPage' => $perPage,
            'search' => $search,
        ]);
    }
}