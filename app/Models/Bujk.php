<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bujk extends Model
{
    protected $table = 'bujk';

    protected const ATTRIBUTE_ALIASES = [
        'nama_bujk' => 'nama_bu',
        'npwp_bujk' => 'npwp',
        'jenis_bujk' => 'jenis_usaha',
        'alamat_bujk' => 'alamat',
        'kab_kota_bujk' => 'kabupaten',
        'provinsi_bujk' => 'propinsi',
        'telp_bujk' => 'telepon',
        'email_bujk' => 'email',
        'website_bujk' => 'website',
    ];

    protected $fillable = [
        'id_izin',
        'nib',
        'npwp',
        'asosiasi',
        'nama_bu',
        'bentuk_usaha',
        'alamat',
        'telepon',
        'email',
        'website',
        'faksimili',
        'propinsi',
        'kabupaten',
        'jenis_usaha',
        'sifat',
        'kbli_bener',
        'kbli_inputan',
        'ket_kbli',
        'bentuk_badan_usaha',
        'klasifikasi',
        'kode_subklasifikasi',
        'subklasifikasi',
        'id_kualifikasi',
        'pelaksana_sertifikasi',
        'tanggal_ditetapkan',
        'tanggal_masa_berlaku',
        'valid',
        'tgl_update',
        'nama_pjbu',
        'nik_pjbu',
        'npwp_pjbu',
        'jenis_perubahan',
        'last_perubahan_at',
        'deskripsi_klasifikasi',
        'status',
        'negara_asal',
        'nama_pjtbu',
        'nama_pjskbu',
        'nama_pjskbu_2',
        'id_asosiasi',
        'is_deleted',

        'nama_bujk',
        'npwp_bujk',
        'jenis_bujk',
        'alamat_bujk',
        'kab_kota_bujk',
        'provinsi_bujk',
        'telp_bujk',
        'email_bujk',
        'website_bujk',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
        'tanggal_ditetapkan' => 'datetime',
        'tanggal_masa_berlaku' => 'datetime',
        'tgl_update' => 'datetime',
        'last_perubahan_at' => 'datetime',
    ];

    public function getAttribute($key)
    {
        if (isset(static::ATTRIBUTE_ALIASES[$key])) {
            return parent::getAttribute(static::ATTRIBUTE_ALIASES[$key]);
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if (isset(static::ATTRIBUTE_ALIASES[$key])) {
            $key = static::ATTRIBUTE_ALIASES[$key];
        }

        if ($key === 'jumlah_tenaga_kerja') {
            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    public function sbu(): HasMany
    {
        return $this->hasMany(BujkSbu::class, 'bujk_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_deleted', false);
    }

    public function getJenisBujkListAttribute(): array
    {
        return collect(explode(',', (string) $this->jenis_usaha))
            ->map(static fn ($item) => trim($item))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public function getKontakDisplayAttribute(): string
    {
        return collect([
            $this->telepon,
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