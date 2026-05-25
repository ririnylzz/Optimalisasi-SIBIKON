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
        return $request->validate(
            [
                '_form_mode' => ['nullable', 'string'],

                'tahun' => ['required', 'integer', 'min:2020'],
                'status' => ['required', 'in:dibuka,selesai'],
                'jenis_peserta' => ['required', 'string', 'max:255'],
                'metode_kegiatan' => ['required', 'string', 'max:255'],
                'nama_kegiatan' => ['required', 'string', 'max:255'],
                'waktu_kegiatan' => ['required', 'date'],
                'realisasi_peserta' => ['required', 'integer', 'min:1'],
                'sumber_dana' => ['required', 'string', 'max:255'],
                'standar_kompetensi' => ['required', 'string', 'max:255'],
                'tuk' => ['required', 'string', 'max:255'],
                'lsp' => ['required', 'string', 'max:255'],
                'tempat_kegiatan' => ['required', 'string', 'max:255'],
                'provinsi' => ['required', 'string', 'max:255'],
                'kabupaten_kota' => ['required', 'string', 'max:255'],

                'syarat_tambahan' => ['nullable', 'string'],
            ],
            [
                'tahun.required' => 'Tahun wajib dipilih.',
                'tahun.integer' => 'Tahun harus berupa angka.',
                'tahun.min' => 'Tahun tidak valid.',

                'status.required' => 'Status Kegiatan wajib dipilih.',
                'status.in' => 'Status Kegiatan tidak valid.',

                'jenis_peserta.required' => 'Jenis Peserta wajib dipilih.',
                'metode_kegiatan.required' => 'Metode Kegiatan wajib dipilih.',

                'nama_kegiatan.required' => 'Nama Kegiatan wajib diisi.',
                'nama_kegiatan.max' => 'Nama Kegiatan maksimal 255 karakter.',

                'waktu_kegiatan.required' => 'Waktu Kegiatan wajib diisi.',
                'waktu_kegiatan.date' => 'Waktu Kegiatan harus berupa tanggal yang valid.',

                'realisasi_peserta.required' => 'Realisasi Jumlah Peserta wajib diisi.',
                'realisasi_peserta.integer' => 'Realisasi Jumlah Peserta harus berupa angka.',
                'realisasi_peserta.min' => 'Realisasi Jumlah Peserta minimal 1.',

                'sumber_dana.required' => 'Sumber Dana wajib dipilih.',
                'standar_kompetensi.required' => 'Standar Kompetensi wajib dipilih.',
                'tuk.required' => 'Tempat Uji Kompetensi wajib diisi.',
                'lsp.required' => 'Lembaga Sertifikasi Profesi wajib dipilih.',
                'tempat_kegiatan.required' => 'Tempat Kegiatan wajib diisi.',
                'provinsi.required' => 'Provinsi wajib dipilih.',
                'kabupaten_kota.required' => 'Kabupaten/Kota wajib dipilih.',
            ]
        );
    }

    private function preparePayload(array $validated): array
    {
        unset($validated['_form_mode']);

        $validated['jabatan_kerja'] = $validated['standar_kompetensi'];
        $validated['tanggal_mulai'] = $validated['waktu_kegiatan'];
        $validated['tanggal_selesai'] = $validated['waktu_kegiatan'];
        $validated['tempat'] = $validated['tempat_kegiatan'];
        $validated['lokasi'] = $validated['kabupaten_kota'];
        $validated['peserta'] = $validated['realisasi_peserta'];

        return $validated;
    }
}