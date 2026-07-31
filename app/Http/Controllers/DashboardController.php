<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $lowStockThreshold = 10;
        
        $lowStockItems = Product::where('stock', '<', $lowStockThreshold)
            ->with('category')
            ->orderBy('stock', 'asc')
            ->get();
            
        $recentTransactions = StockTransaction::with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalStock', 
            'lowStockItems',
            'recentTransactions'
        ));
    }
}
