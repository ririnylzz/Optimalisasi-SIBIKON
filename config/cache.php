<?php

use Illuminate\Support\Str;

return [

    // Cache default yang dipakai aplikasi kalau tidak ditentukan manual
    'default' => env('CACHE_STORE', 'database'),

    // Daftar semua metode penyimpanan cache (database, file, redis, dll)
    'stores' => [

        // Cache sementara di memory (tidak disimpan permanen)
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],

        // Cache menggunakan database tabel
        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CACHE_CONNECTION'),
            'table' => env('DB_CACHE_TABLE', 'cache'),
            'lock_connection' => env('DB_CACHE_LOCK_CONNECTION'),
            'lock_table' => env('DB_CACHE_LOCK_TABLE'),
        ],

        // Cache disimpan sebagai file di storage
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/data'),
        ],

        // Cache pakai Memcached server
        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // opsi tambahan memcached (timeout, dll)
            ],
            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],

        // Cache pakai Redis (lebih cepat untuk sistem besar)
        'redis' => [
            'driver' => 'redis',
            'connection' => env('REDIS_CACHE_CONNECTION', 'cache'),
            'lock_connection' => env('REDIS_CACHE_LOCK_CONNECTION', 'default'),
        ],

        // Cache pakai AWS DynamoDB
        'dynamodb' => [
            'driver' => 'dynamodb',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),
            'endpoint' => env('DYNAMODB_ENDPOINT'),
        ],

        // Cache khusus Laravel Octane
        'octane' => [
            'driver' => 'octane',
        ],

        // Backup cache kalau store utama gagal
        'failover' => [
            'driver' => 'failover',
            'stores' => [
                'database',
                'array',
            ],
        ],

    ],

    // Prefix untuk semua key cache supaya tidak bentrok dengan aplikasi lain
    'prefix' => env('CACHE_PREFIX', Str::slug((string) env('APP_NAME', 'laravel')).'-cache-'),

    // Aturan class yang boleh diserialisasi dari cache (security setting)
    'serializable_classes' => false,

];