<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PemanfaatProduk extends Model
{
    protected $table = 'pemanfaat_produk';

    protected $fillable = [
        'nama_bangunan',
        'pengelola_pemilik_bangunan',
        'lokasi',
        'alamat',
        'kabupaten',
        'provinsi',
        'nama_pengelola_pemilik',
        'tahun_anggaran',
        'kontak',
        'is_deleted',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
        'tahun_anggaran' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_deleted', false);
    }
}