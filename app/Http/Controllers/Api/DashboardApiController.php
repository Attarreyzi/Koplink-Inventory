<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $totalProducts = $products->count();
        $totalStock = $products->sum('stock');
        
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
