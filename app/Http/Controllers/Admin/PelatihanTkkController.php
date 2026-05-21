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
                    ->orWhere('lokasi', 'like', '%' . $search . '%')
                    ->orWhere('tempat', 'like', '%' . $search . '%')
                    ->orWhere('standar_kompetensi', 'like', '%' . $search . '%')
                    ->orWhere('tempat_kegiatan', 'like', '%' . $search . '%')
                    ->orWhere('provinsi', 'like', '%' . $search . '%')
                    ->orWhere('kabupaten_kota', 'like', '%' . $search . '%')
                    ->orWhere('tahun', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('admin.pelatihan-sertifikasi.index', compact('pelatihan'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        PelatihanTkk::create($this->preparePayload($validated));

        return redirect()
            ->route('admin.pelatihan-sertifikasi.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show(PelatihanTkk $pelatihan)
    {
        return view('admin.pelatihan-sertifikasi.show', compact('pelatihan'));
    }

    public function update(Request $request, PelatihanTkk $pelatihan)
    {
        $validated = $this->validateRequest($request);

        $pelatihan->update($this->preparePayload($validated));

        return redirect()
            ->route('admin.pelatihan-sertifikasi.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(PelatihanTkk $pelatihan)
    {
        $pelatihan->delete();

        return redirect()
            ->route('admin.pelatihan-sertifikasi.index')
            ->with('success', 'Data berhasil dihapus');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'tahun' => ['nullable', 'integer'],
            'status' => ['required', 'in:dibuka,selesai'],
            'jenis_peserta' => ['nullable', 'string', 'max:255'],
            'metode_kegiatan' => ['nullable', 'string', 'max:255'],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'waktu_kegiatan' => ['nullable', 'date'],
            'realisasi_peserta' => ['nullable', 'integer', 'min:0'],
            'sumber_dana' => ['nullable', 'string', 'max:255'],
            'standar_kompetensi' => ['nullable', 'string', 'max:255'],
            'tuk' => ['nullable', 'string', 'max:255'],
            'lsp' => ['nullable', 'string', 'max:255'],
            'tempat_kegiatan' => ['nullable', 'string', 'max:255'],
            'provinsi' => ['nullable', 'string', 'max:255'],
            'kabupaten_kota' => ['nullable', 'string', 'max:255'],
            'syarat_tambahan' => ['nullable', 'string'],
        ]);
    }

    private function preparePayload(array $validated): array
    {
        $validated['jabatan_kerja'] = $validated['standar_kompetensi'] ?? '-';
        $validated['tanggal_mulai'] = $validated['waktu_kegiatan'] ?? now()->toDateString();
        $validated['tanggal_selesai'] = $validated['waktu_kegiatan'] ?? now()->toDateString();
        $validated['tempat'] = $validated['tempat_kegiatan'] ?? '-';
        $validated['lokasi'] = $validated['kabupaten_kota'] ?? $validated['provinsi'] ?? '-';
        $validated['peserta'] = $validated['realisasi_peserta'] ?? 0;

        return $validated;
    }
}