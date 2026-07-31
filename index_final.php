<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

try {
    // Register the Composer autoloader...
    require __DIR__.'/vendor/autoload.php';

    // Bootstrap Laravel and handle the request...
    /** @var Application $app */
    $app = require_once __DIR__.'/bootstrap/app.php';

    // Set public path to match htdocs directory if needed
    $app->bind('path.public', function() {
       return __DIR__;
    });

    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    echo "<h1>TANGKAP ERROR:</h1>";
    echo "<b>Pesan:</b> " . $e->getMessage() . "<br><br>";
    echo "<b>Lokasi:</b> " . $e->getFile() . " (Baris " . $e->getLine() . ")<br>";
}
