<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bujk extends Model
{
    protected $table = 'bujk';

    protected $fillable = [
        'nib',
        'nama_bujk',
        'npwp_bujk',
        'jenis_bujk',
        'alamat_bujk',
        'kab_kota_bujk',
        'provinsi_bujk',
        'telp_bujk',
        'email_bujk',
        'website_bujk',
        'jumlah_tenaga_kerja',
        'is_deleted',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
        'jumlah_tenaga_kerja' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_deleted', false);
    }

    public function getJenisBujkListAttribute(): array
    {
        return collect(explode(',', (string) $this->jenis_bujk))
            ->map(static fn ($item) => trim($item))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public function getKontakDisplayAttribute(): string
    {
        return collect([
            $this->telp_bujk,
            $this->email_bujk,
            $this->website_bujk,
        ])->filter()->implode(' / ');
    }

    public function getWebsiteUrlAttribute(): ?string
    {
        if (blank($this->website_bujk)) {
            return null;
        }

        return Str::startsWith($this->website_bujk, ['http://', 'https://'])
            ? $this->website_bujk
            : 'https://' . ltrim($this->website_bujk, '/');
    }
}