<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ReportApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardApiController::class, 'index']);
    
    // Categories
    Route::apiResource('categories', CategoryApiController::class);
    
    // Products
    Route::apiResource('products', ProductApiController::class);
    
    // Stock Transactions
    Route::get('/stock/history', [ProductApiController::class, 'stockHistory']);
    Route::post('/stock/{product}', [ProductApiController::class, 'stockTransaction']);
    
    // Reports
    Route::get('/reports', [ReportApiController::class, 'index']);
});
