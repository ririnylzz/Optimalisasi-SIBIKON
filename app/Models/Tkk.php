<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model TKK: menyimpan data tenaga kerja konstruksi
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
        'created_by',
        'tanggal_input',
        'tanggal_update',
    ];
}