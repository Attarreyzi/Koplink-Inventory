<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// =======================================================
// Controller Transaksi Stok (In/Out) - Koplink Inventory
// =======================================================
class StockController extends Controller
{
    // Tampilkan riwayat semua transaksi mutasi stok
    public function history()
    {
        $transactions = StockTransaction::with('product')->latest()->get();
        return view('admin.stock.history', compact('transactions'));
    }

    // Tampilkan form input transaksi stok (masuk/keluar)
    public function form(Product $product, $type)
    {
        if (!in_array($type, ['in', 'out'])) {
            abort(404);
        }
        return view('admin.stock.form', compact('product', 'type'));
    }

    // Simpan transaksi stok & update jumlah stok produk
    public function store(Request $request, Product $product, $type)
    {
        if (!in_array($type, ['in', 'out'])) {
            abort(404);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:999',
            'note' => 'required|string|max:255',
        ]);

        // Gunakan DB Transaction agar update stok & pencatatan log konsisten
        DB::transaction(function () use ($request, $product, $type) {
            if ($type === 'in') {
                $product->stock += $request->quantity;
            } else {
                // Validasi agar stok tidak minus saat barang keluar
                if ($product->stock < $request->quantity) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'quantity' => 'Stok tidak mencukupi untuk dikeluarkan.',
                    ]);
                }
                $product->stock -= $request->quantity;
            }
            $product->save();

            // Catat log transaksi stok
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

