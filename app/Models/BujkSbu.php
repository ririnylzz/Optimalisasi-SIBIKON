<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BujkSbu extends Model
{
    protected $table = 'bujk_sbu';

    protected $fillable = [
        'bujk_id',
        'id_izin',
        'nib',
        'normalized_nib',
        'sbu_signature',
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
        'status',
        'is_deleted',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
        'tanggal_ditetapkan' => 'datetime',
        'tanggal_masa_berlaku' => 'datetime',
        'tgl_update' => 'datetime',
    ];

    public function bujk(): BelongsTo
    {
        return $this->belongsTo(Bujk::class, 'bujk_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_deleted', false);
    }
}