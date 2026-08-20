<?php

use Illuminate\Support\Str;

return [

    // Driver Session
    'driver' => env('SESSION_DRIVER', 'database'),

    // Masa Berlaku Session (menit)
    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    // Enkripsi Session
    'encrypt' => env('SESSION_ENCRYPT', false),

    // Lokasi File Session
    'files' => storage_path('framework/sessions'),

    // Koneksi & Tabel Database Session
    'connection' => env('SESSION_CONNECTION'),

    'table' => env('SESSION_TABLE', 'sessions'),

    'store' => env('SESSION_STORE'),

    // Lottery Pembersihan Session
    'lottery' => [2, 100],

    // Nama Cookie Session
    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'koplink')).'-session'
    ),

    // Path & Domain Cookie
    'path' => env('SESSION_PATH', '/'),

    'domain' => env('SESSION_DOMAIN'),

    // Keamanan Cookie Session (HTTPS, HttpOnly, SameSite)
    'secure' => env('SESSION_SECURE_COOKIE'),

    'http_only' => env('SESSION_HTTP_ONLY', true),

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];

