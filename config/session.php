<?php

return [

    // driver session default yang dipakai aplikasi (penyimpanan login sementara)
    'driver' => env('SESSION_DRIVER', 'database'),

    // lama sesi login aktif sebelum dianggap habis (dalam menit)
    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    // kalau true, session langsung hilang saat browser ditutup
    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    // kalau true, data session akan dienkripsi (dibuat aman)
    'encrypt' => env('SESSION_ENCRYPT', false),

    // lokasi penyimpanan session kalau pakai file
    'files' => storage_path('framework/sessions'),

    // koneksi database yang dipakai untuk session (kalau pakai database/redis)
    'connection' => env('SESSION_CONNECTION'),

    // nama tabel database untuk menyimpan session user
    'table' => env('SESSION_TABLE', 'sessions'),

    // tempat cache yang dipakai untuk session (redis/memcached dll)
    'store' => env('SESSION_STORE'),

    // peluang sistem membersihkan session lama secara otomatis
    'lottery' => [2, 100],

    // nama cookie session di browser
    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')).'-session'
    ),

    // path cookie berlaku (biasanya seluruh aplikasi)
    'path' => env('SESSION_PATH', '/'),

    // domain yang boleh pakai cookie session
    'domain' => env('SESSION_DOMAIN'),

    // kalau true, session hanya jalan di HTTPS (lebih aman)
    'secure' => env('SESSION_SECURE_COOKIE'),

    // kalau true, JavaScript tidak bisa akses cookie session
    'http_only' => env('SESSION_HTTP_ONLY', true),

    // aturan cookie lintas website (CSRF protection)
    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    // cookie dipisah per situs utama (fitur keamanan tambahan)
    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

    // cara data session disimpan (json lebih aman & umum dipakai)
    'serialization' => 'json',

];