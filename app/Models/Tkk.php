<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tkk extends Model
{
    protected $table = 'tkk';

    protected $fillable = [
        'nama',
        'kabupaten',
        'klasifikasi',
        'jabatan_kerja',
        'jenjang',
        'asosiasi',
        'tanggal_aktif',
        'tanggal_kadaluwarsa',
    ];
}