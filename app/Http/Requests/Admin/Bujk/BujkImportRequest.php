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
        ];
    }

    public function attributes(): array
    {
        return [
            'file_import' => 'file import BUJK',
        ];
    }

    protected function getRedirectUrl(): string
    {
        return parent::getRedirectUrl() . '#upload-bujk';
    }
}