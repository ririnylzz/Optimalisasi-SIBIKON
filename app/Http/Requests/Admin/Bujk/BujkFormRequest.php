<?php

namespace App\Http\Requests\Admin\Bujk;

use App\Support\BujkDataNormalizer;
use Illuminate\Foundation\Http\FormRequest;

class BujkFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(app(BujkDataNormalizer::class)->normalizeFormInput($this->all()));
    }

    public function rules(): array
    {
        return [
            'id_izin' => ['nullable', 'string', 'max:255'],
            'nib' => ['required', 'string', 'max:50'],
            'npwp' => ['nullable', 'string', 'max:50'],
            'asosiasi' => ['nullable', 'string', 'max:255'],
            'nama_bu' => ['required', 'string', 'max:255'],
            'bentuk_usaha' => ['nullable', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email:rfc', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'faksimili' => ['nullable', 'string', 'max:50'],
            'propinsi' => ['required', 'string', 'max:255'],
            'kabupaten' => ['required', 'string', 'max:255'],
            'jenis_usaha' => ['required', 'string', 'max:255'],
            'sifat' => ['nullable', 'string', 'max:255'],
            'kbli_bener' => ['nullable', 'string', 'max:50'],
            'kbli_inputan' => ['nullable', 'string', 'max:50'],
            'ket_kbli' => ['nullable', 'string'],
            'bentuk_badan_usaha' => ['nullable', 'string', 'max:255'],
            'klasifikasi' => ['nullable', 'string', 'max:255'],
            'kode_subklasifikasi' => ['nullable', 'string', 'max:50'],
            'subklasifikasi' => ['nullable', 'string'],
            'id_kualifikasi' => ['nullable', 'string', 'max:50'],
            'pelaksana_sertifikasi' => ['nullable', 'string', 'max:255'],
            'tanggal_ditetapkan' => ['nullable'],
            'tanggal_masa_berlaku' => ['nullable'],
            'valid' => ['nullable', 'string', 'max:50'],
            'tgl_update' => ['nullable'],
            'nama_pjbu' => ['nullable', 'string', 'max:255'],
            'nik_pjbu' => ['nullable', 'string', 'max:50'],
            'npwp_pjbu' => ['nullable', 'string', 'max:50'],
            'jenis_perubahan' => ['nullable', 'string', 'max:50'],
            'last_perubahan_at' => ['nullable'],
            'deskripsi_klasifikasi' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:50'],
            'negara_asal' => ['nullable', 'string', 'max:255'],
            'nama_pjtbu' => ['nullable', 'string', 'max:255'],
            'nama_pjskbu' => ['nullable', 'string', 'max:255'],
            'nama_pjskbu_2' => ['nullable', 'string', 'max:255'],
            'id_asosiasi' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'max' => ':attribute maksimal :max karakter.',
            'email' => 'Format :attribute tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_izin' => 'ID izin',
            'nib' => 'NIB',
            'npwp' => 'NPWP',
            'asosiasi' => 'Asosiasi',
            'nama_bu' => 'Nama BUJK',
            'bentuk_usaha' => 'Bentuk usaha',
            'alamat' => 'Alamat',
            'telepon' => 'Nomor telepon',
            'email' => 'Email',
            'website' => 'Website',
            'faksimili' => 'Faksimili',
            'propinsi' => 'Provinsi',
            'kabupaten' => 'Kabupaten/kota',
            'jenis_usaha' => 'Jenis usaha',
            'sifat' => 'Sifat',
            'kbli_bener' => 'KBLI benar',
            'kbli_inputan' => 'KBLI inputan',
            'ket_kbli' => 'Keterangan KBLI',
            'bentuk_badan_usaha' => 'Bentuk badan usaha',
            'klasifikasi' => 'Klasifikasi',
            'kode_subklasifikasi' => 'Kode subklasifikasi',
            'subklasifikasi' => 'Subklasifikasi',
            'id_kualifikasi' => 'Kualifikasi',
            'pelaksana_sertifikasi' => 'Pelaksana sertifikasi',
            'tanggal_ditetapkan' => 'Tanggal ditetapkan',
            'tanggal_masa_berlaku' => 'Tanggal masa berlaku',
            'valid' => 'Valid',
            'tgl_update' => 'Tanggal update',
            'nama_pjbu' => 'Nama PJBU',
            'nik_pjbu' => 'NIK PJBU',
            'npwp_pjbu' => 'NPWP PJBU',
            'jenis_perubahan' => 'Jenis perubahan',
            'last_perubahan_at' => 'Perubahan terakhir',
            'deskripsi_klasifikasi' => 'Deskripsi klasifikasi',
            'status' => 'Status',
            'negara_asal' => 'Negara asal',
            'nama_pjtbu' => 'Nama PJTBU',
            'nama_pjskbu' => 'Nama PJSKBU',
            'nama_pjskbu_2' => 'Nama PJSKBU 2',
            'id_asosiasi' => 'ID asosiasi',
        ];
    }

    protected function getRedirectUrl(): string
    {
        return parent::getRedirectUrl() . '#form-bujk';
    }
}