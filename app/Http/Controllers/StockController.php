<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function history()
    {
        $transactions = StockTransaction::with('product')->latest()->get();
        return view('admin.stock.history', compact('transactions'));
    }

    public function form(Product $product, $type)
    {
        if (!in_array($type, ['in', 'out'])) {
            abort(404);
        }
        return view('admin.stock.form', compact('product', 'type'));
    }

    public function store(Request $request, Product $product, $type)
    {
        if (!in_array($type, ['in', 'out'])) {
            abort(404);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:999',
            'note' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $product, $type) {
            if ($type === 'in') {
                $product->stock += $request->quantity;
            } else {
                if ($product->stock < $request->quantity) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'quantity' => 'Stok tidak mencukupi untuk dikeluarkan.',
                    ]);
                }
                $product->stock -= $request->quantity;
            }
            $product->save();

            StockTransaction::create([
                'product_id' => $product->id,
                'type' => $type,
                'quantity' => $request->quantity,
                'note' => $request->note,
            ]);
        });

        return redirect()->route('admin.products.index')->with('success', 'Transaksi stok berhasil.');
    }
}
