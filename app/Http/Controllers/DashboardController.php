<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

// =======================================================
// Controller Dashboard Admin - Ringkasan Stok & Transaksi
// =======================================================
class DashboardController extends Controller
{
    // Halaman utama ringkasan statistik inventaris
    public function index()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $lowStockThreshold = 10; // Batas minimal peringatan stok nipis
        
        // Ambil produk dengan stok yang hampir habis
        $lowStockItems = Product::where('stock', '<', $lowStockThreshold)
            ->with('category')
            ->orderBy('stock', 'asc')
            ->get();
            
        // Ambil 5 riwayat transaksi stok terbaru
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

