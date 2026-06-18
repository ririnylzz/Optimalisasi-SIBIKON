<?php

use App\Models\User;

return [

    // Default konfigurasi autentikasi (guard & password reset)
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    // Pengaturan cara login user (session-based authentication)
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    // Sumber data user yang dipakai untuk autentikasi (biasanya model User)
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', User::class),
        ],
    ],

    // Konfigurasi reset password (token, expiry, throttle)
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    // Waktu timeout sebelum user diminta input password ulang (dalam detik)
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];