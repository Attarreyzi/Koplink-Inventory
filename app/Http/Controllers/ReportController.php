<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

// =======================================================
// Controller Laporan & Profit Penjualan - Koplink
// =======================================================
class ReportController extends Controller
{
    // Generate data laporan transaksi & estimasi keuntungan
    public function index(Request $request)
    {
        $products = Product::all();
        // Total nilai aset inventaris (stok * harga jual)
        $totalValuation = $products->sum(function ($product) {
            return $product->stock * $product->price;
        });

        $totalStock = $products->sum('stock');

        // Filter riwayat transaksi berdasarkan rentang tanggal
        $query = StockTransaction::query();
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }
        
        $transactions = $query->with('product')->latest()->get();

        // Hitung total item masuk & keluar
        $stockInCount = $transactions->where('type', 'in')->sum('quantity');
        $stockOutCount = $transactions->where('type', 'out')->sum('quantity');

        // Hitung estimasi keuntungan dari barang yang keluar
        $totalProfit = $transactions->where('type', 'out')->sum(function ($transaction) {
            $profitPerUnit = $transaction->product->price - $transaction->product->purchase_price;
            return $profitPerUnit * $transaction->quantity;
        });

        // Hitung total omzet / pendapatan
        $totalRevenue = $transactions->where('type', 'out')->sum(function ($transaction) {
            return $transaction->product->price * $transaction->quantity;
        });

        return view('admin.reports.index', compact(
            'products', 
            'totalValuation', 
            'totalStock', 
            'stockInCount', 
            'stockOutCount',
            'transactions',
            'totalProfit',
            'totalRevenue'
        ));
    }
}

