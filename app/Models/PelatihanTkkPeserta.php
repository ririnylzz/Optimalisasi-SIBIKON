<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelatihanTkkPeserta extends Model
{
    // Menentukan nama tabel database yang digunakan oleh model ini
    protected $table = 'pelatihan_tkk_peserta';

    // Field yang diperbolehkan untuk mass assignment (create/update data sekaligus)
    protected $fillable = [
        'pelatihan_tkk_id',
        'nama',
        'nik',
        'email',
        'telp',
        'pendidikan_jurusan',
        'asn',
        'jabatan_instansi',
        'alamat',
        'provinsi',
        'kab_kota',
        'waktu_daftar',
        'status_peserta',
    ];

    // Casting otomatis untuk mengubah format kolom waktu_daftar menjadi datetime
    protected $casts = [
        'waktu_daftar' => 'datetime',
    ];
}