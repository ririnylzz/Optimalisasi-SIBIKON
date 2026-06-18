<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelatihanTkk extends Model
{
    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'pelatihan_tkk';

    // Menentukan field yang boleh diisi secara mass assignment (create/update)
    protected $fillable = [
        'tahun',
        'nama_kegiatan',
        'jabatan_kerja',
        'tanggal_mulai',
        'tanggal_selesai',
        'tempat',
        'lokasi',
        'peserta',
        'status',
        'jenis_peserta',
        'metode_kegiatan',
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