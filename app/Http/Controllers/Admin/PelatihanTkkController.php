<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PelatihanTkk;
use App\Models\PelatihanTkkPeserta;
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

    public function show(PelatihanTkk $pelatihan)
    {
        $pesertaRows = PelatihanTkkPeserta::where('pelatihan_tkk_id', $pelatihan->id)
            ->latest()
            ->get();

        $pendaftarByKabupaten = $pesertaRows
            ->groupBy(fn ($item) => $item->kab_kota ?: 'Tidak Diketahui')
            ->map(function ($items, $kabupaten) {
                return [
                    'kabupaten' => $kabupaten,
                    'jumlah' => $items->count(),
                ];
            })
            ->values();

        $pendaftarByStatus = $pesertaRows
            ->groupBy(fn ($item) => $item->status_peserta ?: 'Calon Peserta')
            ->map(function ($items, $status) {
                return [
                    'status' => $status,
                    'jumlah' => $items->count(),
                ];
            })
            ->values();

        return view('admin.pelatihan-sertifikasi.show', compact(
            'pelatihan',
            'pesertaRows',
            'pendaftarByKabupaten',
            'pendaftarByStatus'
        ));
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

    public function storePeserta(Request $request, PelatihanTkk $pelatihan)
    {
        $validated = $this->validatePesertaRequest($request);

        $validated['pelatihan_tkk_id'] = $pelatihan->id;

        PelatihanTkkPeserta::create($validated);

        return redirect()
            ->route('admin.pelatihan-sertifikasi.show', $pelatihan)
            ->with('success', 'Data peserta berhasil ditambahkan');
    }

    public function updatePeserta(Request $request, PelatihanTkk $pelatihan, PelatihanTkkPeserta $peserta)
    {
        if ((int) $peserta->pelatihan_tkk_id !== (int) $pelatihan->id) {
            abort(404);
        }

        $validated = $this->validatePesertaRequest($request);

        $peserta->update($validated);

        return redirect()
            ->route('admin.pelatihan-sertifikasi.show', $pelatihan)
            ->with('success', 'Data peserta berhasil diperbarui');
    }

    public function destroyPeserta(PelatihanTkk $pelatihan, PelatihanTkkPeserta $peserta)
    {
        if ((int) $peserta->pelatihan_tkk_id !== (int) $pelatihan->id) {
            abort(404);
        }

        $peserta->delete();

        return redirect()
            ->route('admin.pelatihan-sertifikasi.show', $pelatihan)
            ->with('success', 'Data peserta berhasil dihapus');
    }

    public function bulkDestroyPeserta(Request $request, PelatihanTkk $pelatihan)
    {
        $validated = $request->validate(
            [
                'peserta_ids' => ['required', 'array', 'min:1'],
                'peserta_ids.*' => ['required', 'integer'],
            ],
            [
                'peserta_ids.required' => 'Pilih minimal satu peserta yang ingin dihapus.',
                'peserta_ids.array' => 'Data peserta tidak valid.',
                'peserta_ids.min' => 'Pilih minimal satu peserta yang ingin dihapus.',
            ]
        );

        PelatihanTkkPeserta::where('pelatihan_tkk_id', $pelatihan->id)
            ->whereIn('id', $validated['peserta_ids'])
            ->delete();

        return redirect()
            ->route('admin.pelatihan-sertifikasi.show', $pelatihan)
            ->with('success', 'Data peserta terpilih berhasil dihapus');
    }

    public function destroyAllPeserta(PelatihanTkk $pelatihan)
    {
        PelatihanTkkPeserta::where('pelatihan_tkk_id', $pelatihan->id)->delete();

        return redirect()
            ->route('admin.pelatihan-sertifikasi.show', $pelatihan)
            ->with('success', 'Semua data peserta berhasil dihapus');
    }

    private function validatePesertaRequest(Request $request): array
    {
        return $request->validate(
            [
                'nama' => ['required', 'string', 'max:255'],
                'nik' => ['required', 'regex:/^[0-9]+$/', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'telp' => ['required', 'regex:/^[0-9]+$/', 'max:255'],
                'pendidikan_jurusan' => ['required', 'in:D4,S1,S2,S3'],
                'asn' => ['required', 'in:Ya,Tidak'],
                'jabatan_instansi' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string'],
                'provinsi' => ['required', 'string', 'max:255'],
                'kab_kota' => ['required', 'string', 'max:255'],
                'waktu_daftar' => ['required', 'date'],
                'status_peserta' => ['required', 'string', 'max:255'],
            ],
            [
                'nama.required' => 'Nama wajib diisi.',

                'nik.required' => 'NIK wajib diisi.',
                'nik.regex' => 'NIK harus diisi dengan angka.',

                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',

                'telp.required' => 'No. Telp wajib diisi.',
                'telp.regex' => 'No. Telp harus diisi dengan angka.',

                'pendidikan_jurusan.required' => 'Pendidikan/Jurusan wajib dipilih.',
                'pendidikan_jurusan.in' => 'Pendidikan/Jurusan tidak valid.',

                'asn.required' => 'ASN wajib dipilih.',
                'asn.in' => 'Pilihan ASN tidak valid.',

                'jabatan_instansi.required' => 'Jabatan/Instansi wajib diisi.',
                'alamat.required' => 'Alamat wajib diisi.',

                'provinsi.required' => 'Provinsi wajib dipilih.',
                'kab_kota.required' => 'Kab./Kota wajib dipilih.',

                'waktu_daftar.required' => 'Waktu Daftar wajib diisi.',
                'waktu_daftar.date' => 'Waktu Daftar tidak valid.',

                'status_peserta.required' => 'Status Peserta wajib dipilih.',
            ]
        );
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