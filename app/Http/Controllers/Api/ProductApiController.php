<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\StockTransaction;

class ProductApiController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        } else {
            $validated['image'] = null;
        }

        $product = Product::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product
        ]);
    }

    public function show(Product $product)
    {
        $product->load('category');
        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        // For processing multipart/form-data via PUT/PATCH, 
        // Laravel needs a POST request with _method=PUT to handle files properly in PHP.
        // It's a common gotcha but we'll manage it the Laravel way.

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil diubah',
            'data' => $product
        ]);
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus'
        ]);
    }

    // Stock Transactions
    public function stockHistory()
    {
        $transactions = StockTransaction::with('product')->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ]);
    }

    public function stockTransaction(Request $request, Product $product)
    {
        $validated = $request->validate([
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($validated, $product) {
                if ($validated['type'] === 'in') {
                    $product->stock += $validated['quantity'];
                } else {
                    if ($product->stock < $validated['quantity']) {
                        throw new \Exception('Stok tidak mencukupi untuk dikeluarkan.');
                    }
                    $product->stock -= $validated['quantity'];
                }
                $product->save();

                StockTransaction::create([
                    'product_id' => $product->id,
                    'type' => $validated['type'],
                    'quantity' => $validated['quantity'],
                    'note' => $validated['note'],
                ]);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi stok berhasil',
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
