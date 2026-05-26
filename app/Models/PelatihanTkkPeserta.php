<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelatihanTkkPeserta extends Model
{
    protected $table = 'pelatihan_tkk_peserta';

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

    protected $casts = [
        'waktu_daftar' => 'datetime',
    ];
}