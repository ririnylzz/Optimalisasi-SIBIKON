<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PelatihanTkk;
use Illuminate\Http\Request;

class PelatihanTkkController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $pelatihan = PelatihanTkk::when($search, function ($query) use ($search) {
            $query->where('nama_kegiatan', 'like', '%' . $search . '%')
                ->orWhere('jabatan_kerja', 'like', '%' . $search . '%')
                ->orWhere('lokasi', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(10);

        return view('admin.pelatihan-sertifikasi.index', compact('pelatihan'));
    }

    public function create()
    {
        return view('admin.pelatihan-sertifikasi.create');
    }
}