<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

// =======================================================
// Endpoint API Laporan - Valuasi & Mutasi Stok
// =======================================================
class ReportApiController extends Controller
{
    // Replikasi data laporan inventaris & statistik stok
    public function index(Request $request)
    {
        $products = Product::all();
        $totalValuation = $products->sum(function ($product) {
            return $product->stock * $product->price;
        });

        $totalStock = $products->sum('stock');

        // Filter berdasarkan tanggal jika dikirimkan
        $query = StockTransaction::query();
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }
        
        $transactions = $query->with('product')->latest()->get();

        $stockInCount = $transactions->where('type', 'in')->sum('quantity');
        $stockOutCount = $transactions->where('type', 'out')->sum('quantity');

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_valuation' => $totalValuation,
                'total_stock' => $totalStock,
                'stock_in_count' => $stockInCount,
                'stock_out_count' => $stockOutCount,
                'transactions' => $transactions
            ]
        ]);
    }
}

