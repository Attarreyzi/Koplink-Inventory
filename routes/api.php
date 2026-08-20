<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ReportApiController;

/*
|--------------------------------------------------------------------------
| API Routes - Koplink Inventory Web
|--------------------------------------------------------------------------
*/

// Check user session Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Group Endpoint API Admin
Route::prefix('admin')->group(function () {
    // Ringkasan Dashboard
    Route::get('/dashboard', [DashboardApiController::class, 'index']);
    
    // Manajemen Kategori Produk
    Route::apiResource('categories', CategoryApiController::class);
    
    // Manajemen Produk
    Route::apiResource('products', ProductApiController::class);
    
    // Transaksi Stok & Riwayat Mutasi
    Route::get('/stock/history', [ProductApiController::class, 'stockHistory']);
    Route::post('/stock/{product}', [ProductApiController::class, 'stockTransaction']);
    
    // Laporan & Statistik Inventaris
    Route::get('/reports', [ReportApiController::class, 'index']);
});

