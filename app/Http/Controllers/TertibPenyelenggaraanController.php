<?php

namespace App\Http\Controllers;

use App\Models\TertibPenyelenggaraan;
use Illuminate\Http\Request;

class TertibPenyelenggaraanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paket_pekerjaan' => ['required', 'string', 'max:255'],
            'penyedia' => ['required', 'string', 'max:255'],
            'nomor_kontrak' => ['required', 'string', 'max:255'],
            'awal_kerja' => ['nullable', 'date'],
            'akhir_kerja' => ['nullable', 'date', 'after_or_equal:awal_kerja'],

            'surat_pernyataan_1' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'surat_pernyataan_2' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'surat_pernyataan_3' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'surat_pernyataan_4' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'surat_pernyataan_5' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],

            'dokumen_pendukung_1' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'dokumen_pendukung_2' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'dokumen_pendukung_3' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'dokumen_pendukung_4' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'dokumen_pendukung_5' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
        ], [
            'paket_pekerjaan.required' => 'Paket pekerjaan wajib dipilih.',
            'penyedia.required' => 'Penyedia wajib diisi.',
            'nomor_kontrak.required' => 'Nomor kontrak wajib diisi.',
            'akhir_kerja.after_or_equal' => 'Akhir kerja tidak boleh lebih awal dari awal kerja.',
            '*.mimes' => 'Dokumen harus berupa PDF, DOC, DOCX, JPG, JPEG, atau PNG.',
            '*.max' => 'Ukuran dokumen maksimal 5MB.',
        ]);

        $dokumenPengawasan = [];

        for ($i = 1; $i <= 5; $i++) {
            $suratKey = "surat_pernyataan_{$i}";
            $pendukungKey = "dokumen_pendukung_{$i}";

            $dokumenPengawasan[$i] = [
                'surat_pernyataan' => null,
                'dokumen_pendukung' => null,
            ];

            if ($request->hasFile($suratKey)) {
                $dokumenPengawasan[$i]['surat_pernyataan'] = $request
                    ->file($suratKey)
                    ->store('tertib-penyelenggaraan/surat-pernyataan', 'public');
            }

            if ($request->hasFile($pendukungKey)) {
                $dokumenPengawasan[$i]['dokumen_pendukung'] = $request
                    ->file($pendukungKey)
                    ->store('tertib-penyelenggaraan/dokumen-pendukung', 'public');
            }
        }

        TertibPenyelenggaraan::create([
            'paket_pekerjaan' => $validated['paket_pekerjaan'],
            'penyedia' => $validated['penyedia'],
            'nomor_kontrak' => $validated['nomor_kontrak'],
            'awal_kerja' => $validated['awal_kerja'] ?? null,
            'akhir_kerja' => $validated['akhir_kerja'] ?? null,
            'dokumen_pengawasan' => $dokumenPengawasan,
        ]);

        return back()->with('success', 'Data pengawasan tertib penyelenggaraan berhasil disimpan.');
    }
}