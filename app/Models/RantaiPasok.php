<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RantaiPasok extends Model
{
    protected $table = 'rantai_pasok';

    protected $fillable = [
        'nama',
        'bidang_usaha',
        'alamat',
        'kabupaten',
        'provinsi',
        'kontak',
        'email',
        'website',
        'is_deleted',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_deleted', false);
    }

    public function getKontakDisplayAttribute(): string
    {
        return collect([
            $this->kontak,
            $this->email,
            $this->website,
        ])->filter()->implode(' / ');
    }

    public function getWebsiteUrlAttribute(): ?string
    {
        if (blank($this->website)) {
            return null;
        }

        $website = trim((string) $this->website);

        if (preg_match('/^https?:\/\//i', $website)) {
            return $website;
        }

        return 'https://' . $website;
    }
}