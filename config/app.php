<?php

return [

    // Nama aplikasi yang digunakan di seluruh sistem
    'name' => env('APP_NAME', 'Laravel'),

    // Menentukan environment aplikasi seperti local atau production
    'env' => env('APP_ENV', 'production'),

    // Menampilkan detail error jika debug aktif
    'debug' => (bool) env('APP_DEBUG', false),

    // URL utama aplikasi untuk generate link
    'url' => env('APP_URL', 'http://localhost'),

    // Zona waktu default aplikasi
    'timezone' => 'UTC',

    // Bahasa default aplikasi
    'locale' => env('APP_LOCALE', 'en'),

    // Bahasa cadangan jika bahasa utama tidak tersedia
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    // Bahasa untuk data dummy/testing
    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    // Kunci enkripsi utama aplikasi
    'cipher' => 'AES-256-CBC',

    // Key utama aplikasi untuk keamanan
    'key' => env('APP_KEY'),

    // Key lama yang masih bisa dipakai untuk dekripsi data lama
    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    // Pengaturan mode maintenance aplikasi
    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];