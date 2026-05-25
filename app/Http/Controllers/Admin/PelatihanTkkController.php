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
        PelatihanTkk::create([
            'tahun' => $request->tahun,
            'status' => $request->status,
            'jenis_peserta' => $request->jenis_peserta,
            'metode_kegiatan' => $request->metode_kegiatan,
            'nama_kegiatan' => $request->nama_kegiatan,
            'waktu_kegiatan' => $request->waktu_kegiatan,
            'realisasi_peserta' => $request->realisasi_peserta,
            'sumber_dana' => $request->sumber_dana,
            'standar_kompetensi' => $request->standar_kompetensi,
            'tuk' => $request->tuk,
            'lsp' => $request->lsp,
            'tempat_kegiatan' => $request->tempat_kegiatan,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'syarat_tambahan' => $request->syarat_tambahan,
        ]);

        return redirect()
            ->route('admin.pelatihan-sertifikasi.index')
            ->with('success', 'Data berhasil ditambahkan');
    }
}