<?php

namespace App\Http\Requests\Admin\Bujk;

use App\Support\BujkDataNormalizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $currentId = $this->route('bujk')?->id;

        return [
            'nib' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bujk', 'nib')
                    ->ignore($currentId)
                    ->where(static fn ($query) => $query->where('is_deleted', false)),
            ],
            'nama_bujk' => ['required', 'string', 'max:255'],
            'npwp_bujk' => ['nullable', 'string', 'max:50'],
            'jenis_bujk' => ['required', 'string', 'max:100'],
            'alamat_bujk' => ['required', 'string'],
            'kab_kota_bujk' => ['required', 'string', 'max:255'],
            'provinsi_bujk' => ['required', 'string', 'max:255'],
            'telp_bujk' => ['nullable', 'string', 'max:50'],
            'email_bujk' => ['nullable', 'email:rfc', 'max:255'],
            'website_bujk' => ['nullable', 'string', 'max:255'],
            'jumlah_tenaga_kerja' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nib' => 'NIB',
            'nama_bujk' => 'nama BUJK',
            'npwp_bujk' => 'NPWP',
            'jenis_bujk' => 'jenis usaha',
            'alamat_bujk' => 'alamat',
            'kab_kota_bujk' => 'kabupaten/kota',
            'provinsi_bujk' => 'provinsi',
            'telp_bujk' => 'nomor telepon',
            'email_bujk' => 'email',
            'website_bujk' => 'website',
        ];
    }

    public function messages(): array
    {
        return [
            'nib.unique' => 'NIB sudah terdaftar pada data BUJK aktif.',
        ];
    }

    protected function getRedirectUrl(): string
    {
        return parent::getRedirectUrl() . '#form-bujk';
    }
}