<?php

return [

    // Tempat menyimpan pengaturan layanan pihak ketiga (API luar)
    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    // API untuk layanan email Resend
    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    // Pengaturan AWS untuk layanan email / layanan cloud Amazon
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // Pengaturan Slack untuk kirim notifikasi ke channel
    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];