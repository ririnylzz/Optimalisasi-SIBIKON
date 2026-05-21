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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'nullable',
            'status' => 'nullable',
            'jenis_peserta' => 'nullable',
            'metode_kegiatan' => 'nullable',
            'nama_kegiatan' => 'required',
            'waktu_kegiatan' => 'nullable',
            'realisasi_peserta' => 'nullable',
            'sumber_dana' => 'nullable',
            'standar_kompetensi' => 'nullable',
            'tuk' => 'nullable',
            'lsp' => 'nullable',
            'tempat_kegiatan' => 'nullable',
            'provinsi' => 'nullable',
            'kabupaten_kota' => 'nullable',
            'syarat_tambahan' => 'nullable',
        ]);

        PelatihanTkk::create($validated);

        return redirect()
            ->route('admin.pelatihan-sertifikasi.index')
            ->with('success', 'Data berhasil ditambahkan');
    }
}