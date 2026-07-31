<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        $totalValuation = $products->sum(function ($product) {
            return $product->stock * $product->price;
        });

        $totalStock = $products->sum('stock');

        $query = StockTransaction::query();
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }
        
        $transactions = $query->with('product')->latest()->get();

        $stockInCount = $transactions->where('type', 'in')->sum('quantity');
        $stockOutCount = $transactions->where('type', 'out')->sum('quantity');

        $totalProfit = $transactions->where('type', 'out')->sum(function ($transaction) {
            $profitPerUnit = $transaction->product->price - $transaction->product->purchase_price;
            return $profitPerUnit * $transaction->quantity;
        });

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
