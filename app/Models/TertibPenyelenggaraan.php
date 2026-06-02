<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TertibPenyelenggaraan extends Model
{
    protected $table = 'tertib_penyelenggaraan';

    protected $fillable = [
        'paket_pekerjaan',
        'penyedia',
        'nomor_kontrak',
        'awal_kerja',
        'akhir_kerja',
        'dokumen_pengawasan',
    ];

    protected $casts = [
        'awal_kerja' => 'date',
        'akhir_kerja' => 'date',
        'dokumen_pengawasan' => 'array',
    ];
}