<?php

namespace App\Http\Requests\Admin\Bujk;

use Illuminate\Foundation\Http\FormRequest;

class BujkImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file_import' => ['required', 'file', 'mimes:csv,txt,xlsx', 'max:20480'],
            'tanggal_data_terbaru' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'file_import.required' => 'File import wajib diisi.',
            'file_import.file' => 'File import harus berupa file yang valid.',
            'file_import.mimes' => 'File import harus berformat CSV, TXT, atau XLSX.',
            'file_import.max' => 'Ukuran file import maksimal 20 MB.',

            'tanggal_data_terbaru.required' => 'Tanggal data terbaru wajib diisi.',
            'tanggal_data_terbaru.date' => 'Tanggal data terbaru harus berupa tanggal yang valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'file_import' => 'file import',
            'tanggal_data_terbaru' => 'tanggal data terbaru',
        ];
    }
}