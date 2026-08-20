<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

// =======================================================
// Endpoint API Dashboard - Ringkasan Stok & Inventaris
// =======================================================
class DashboardApiController extends Controller
{
    // Ringkasan data produk & stok nipis
    public function index()
    {
        $products = Product::all();
        $totalProducts = $products->count();
        $totalStock = $products->sum('stock');
        
        // Produk dengan stok di bawah threshold (10)
        $lowStockProducts = $products->where('stock', '<', 10)->values();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_products' => $totalProducts,
                'total_stock' => $totalStock,
                'low_stock_products' => $lowStockProducts
            ]
        ]);
    }
}

