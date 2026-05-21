<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelatihanTkk extends Model
{
    protected $table = 'pelatihan_tkk';

    protected $fillable = [
        'tahun',
        'status',
        'jenis_peserta',
        'metode_kegiatan',
        'nama_kegiatan',
        'waktu_kegiatan',
        'realisasi_peserta',
        'sumber_dana',
        'standar_kompetensi',
        'tuk',
        'lsp',
        'tempat_kegiatan',
        'provinsi',
        'kabupaten_kota',
        'syarat_tambahan',
    ];
}