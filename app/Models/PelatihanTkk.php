<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelatihanTkk extends Model
{
    protected $table = 'pelatihan_tkk';

    protected $fillable = [
        'tahun',
        'status_kegiatan',
        'jenis_peserta',
        'metode_kegiatan',
        'nama_kegiatan',
        'waktu_kegiatan',
        'realisasi_jumlah_peserta',
        'sumber_dana',
        'standar_kompetensi',
        'tempat_uji_kompetensi',
        'lsp',
        'tempat_kegiatan',
        'provinsi',
        'kabupaten_kota',
        'syarat_tambahan',
    ];
}