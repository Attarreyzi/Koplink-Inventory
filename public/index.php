<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Cek mode maintenance
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

try {
    // Autoload Composer
    require __DIR__.'/../vendor/autoload.php';

    // Inisialisasi aplikasi Laravel
    /** @var Application $app */
    $app = require_once __DIR__.'/../bootstrap/app.php';

    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    echo "<h1>TANGKAP ERROR:</h1>";
    echo "<b>Pesan:</b> " . $e->getMessage() . "<br><br>";
    echo "<b>Lokasi:</b> " . $e->getFile() . " (Baris " . $e->getLine() . ")<br>";
}

