<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Tempat untuk mendaftarkan layanan/aplikasi tambahan (service binding)
    public function register(): void
    {
        //
    }

    // Tempat untuk menjalankan kode saat aplikasi pertama kali hidup
    public function boot(): void
    {
        //
    }
}