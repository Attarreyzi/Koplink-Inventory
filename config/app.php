<?php

return [

    // Nama Aplikasi
    'name' => env('APP_NAME', 'Koplink Inventory'),

    // Environment aplikasi
    'env' => env('APP_ENV', 'production'),

    // Mode debug
    'debug' => (bool) env('APP_DEBUG', false),

    // URL dasar aplikasi
    'url' => env('APP_URL', 'http://localhost'),

    // Zona waktu aplikasi
    'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),

    // Pengaturan bahasa / Lokalisasi
    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    // Kunci Enkripsi Aplikasi
    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    // Driver Mode Pemeliharaan (Maintenance)
    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];

