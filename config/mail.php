<?php

return [

    // Mailer utama yang dipakai untuk kirim email
    'default' => env('MAIL_MAILER', 'log'),

    // Pengaturan semua cara kirim email
    'mailers' => [

        // Kirim email pakai SMTP (cara paling umum)
        'smtp' => [
            'transport' => 'smtp',
            'scheme' => env('MAIL_SCHEME'),
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 2525),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env(
                'MAIL_EHLO_DOMAIN',
                parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)
            ),
        ],

        // Kirim email lewat AWS SES
        'ses' => [
            'transport' => 'ses',
        ],

        // Kirim email lewat Postmark
        'postmark' => [
            'transport' => 'postmark',
        ],

        // Kirim email lewat Resend
        'resend' => [
            'transport' => 'resend',
        ],

        // Kirim email lewat server sendmail
        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        // Email tidak dikirim, hanya disimpan ke log
        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        // Email cuma ditampung di array (buat testing)
        'array' => [
            'transport' => 'array',
        ],

        // Kalau gagal kirim, coba SMTP dulu, kalau gagal pakai log
        'failover' => [
            'transport' => 'failover',
            'mailers' => ['smtp', 'log'],
            'retry_after' => 60,
        ],

        // Coba kirim email bergantian (SES atau Postmark)
        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => ['ses', 'postmark'],
            'retry_after' => 60,
        ],
    ],

    // Alamat pengirim default semua email
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', env('APP_NAME', 'Laravel')),
    ],

];