<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Utility route untuk auto-repair folder storage di shared hosting
Route::get('/perbaiki-folder', function () {
    $directories = [
        storage_path('framework/sessions'),
        storage_path('framework/views'),
        storage_path('framework/cache'),
        storage_path('logs'),
        base_path('bootstrap/cache'),
    ];
    $output = "<h2>Memperbaiki Folder Storage...</h2><ul>";
    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
            $output .= "<li style='color:green;'>Berhasil membuat: $dir</li>";
        } else {
            $output .= "<li style='color:blue;'>Sudah ada: $dir</li>";
        }
    }
    return $output . "</ul><h3 style='color:green;'>Selesai!</h3><a href='/login'>Klik di sini untuk Login</a>";
});

// Serve gambar produk yang di-store di storage/app/public
Route::get('/img-view/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath);
})->where('path', '.*');

// Route Otentikasi Admin
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login']);
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Redirect root URL ke login admin
Route::get('/', function() {
    return redirect()->route('login');
});

// Route Panel Admin (Memerlukan Login)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('/', function () { return redirect()->route('admin.dashboard'); });
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', CategoryController::class)->except(['edit', 'update']);
    
    // Transaksi & Riwayat Stok
    Route::get('stock', [StockController::class, 'history'])->name('stock.history');
    Route::get('stock/{product}/{type}', [StockController::class, 'form'])->name('stock.form');
    Route::post('stock/{product}/{type}', [StockController::class, 'store'])->name('stock.store');
    
    // Laporan Inventaris & Profit
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});

