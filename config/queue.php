<?php

return [

    // Pengaturan default koneksi queue yang dipakai aplikasi
    'default' => env('QUEUE_CONNECTION', 'database'),

    // Daftar semua jenis antrian (queue) yang bisa dipakai aplikasi
    'connections' => [

        // Queue langsung jalan tanpa antre (langsung eksekusi)
        'sync' => [
            'driver' => 'sync',
        ],

        // Queue pakai database (job disimpan dulu di tabel)
        'database' => [
            'driver' => 'database',
            'connection' => env('DB_QUEUE_CONNECTION'),
            'table' => env('DB_QUEUE_TABLE', 'jobs'),
            'queue' => env('DB_QUEUE', 'default'),
            'retry_after' => (int) env('DB_QUEUE_RETRY_AFTER', 90),
            'after_commit' => false,
        ],

        // Queue pakai Beanstalkd (server antrian khusus)
        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => env('BEANSTALKD_QUEUE_HOST', 'localhost'),
            'queue' => env('BEANSTALKD_QUEUE', 'default'),
            'retry_after' => (int) env('BEANSTALKD_QUEUE_RETRY_AFTER', 90),
            'block_for' => 0,
            'after_commit' => false,
        ],

        // Queue pakai AWS SQS (layanan queue dari Amazon)
        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'default'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'after_commit' => false,
        ],

        // Queue pakai Redis (lebih cepat karena di memory)
        'redis' => [
            'driver' => 'redis',
            'connection' => env('REDIS_QUEUE_CONNECTION', 'default'),
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => (int) env('REDIS_QUEUE_RETRY_AFTER', 90),
            'block_for' => null,
            'after_commit' => false,
        ],

        // Queue ditunda (belum langsung dijalankan)
        'deferred' => [
            'driver' => 'deferred',
        ],

        // Queue jalan di background (proses di belakang layar)
        'background' => [
            'driver' => 'background',
        ],

        // Kalau gagal, coba koneksi queue lain dulu
        'failover' => [
            'driver' => 'failover',
            'connections' => [
                'database',
                'deferred',
            ],
        ],

    ],

    // Pengaturan penyimpanan batch job (job yang jalan bareng-bareng)
    'batching' => [
        'database' => env('DB_CONNECTION', 'sqlite'),
        'table' => 'job_batches',
    ],

    // Pengaturan job yang gagal dijalankan
    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'sqlite'),
        'table' => 'failed_jobs',
    ],

];