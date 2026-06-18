<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // memakai factory User untuk testing dan seeding data
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nik',
        'email',
        'telepon',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Mengatur data yang otomatis dikonversi (cast) seperti tanggal & password
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}