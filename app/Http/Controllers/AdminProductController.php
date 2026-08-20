<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

// =======================================================
// Controller Manajemen Produk Admin - Koplink Inventory
// =======================================================
class AdminProductController extends Controller
{
    // Tampilkan daftar semua produk beserta kategorinya
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    // Form tambah produk baru
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Simpan data produk baru ke database
    public function store(Request $request)
    {
        // Validasi input produk
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'image' => 'nullable|max:5120',
            'stock' => 'required|integer|min:0',
        ], [
            'name.unique' => 'Produk ini sudah tersedia.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'name.required' => 'Nama produk wajib diisi.',
            'price.required' => 'Harga jual wajib diisi.',
            'purchase_price.required' => 'Harga modal wajib diisi.',
        ]);

        // Upload gambar jika ada file yang dikirim
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/products');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['image'] = 'public/uploads/products/' . $filename;
        }

        // Simpan produk & catat transaksi stok awal
        DB::transaction(function () use ($validated) {
            $product = Product::create($validated);

            if ($product->stock > 0) {
                StockTransaction::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $product->stock,
                    'note' => 'Stok Awal',
                ]);
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Form edit data produk
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update data produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'image' => 'nullable|max:5120',
        ], [
            'name.unique' => 'Produk ini sudah tersedia.',
            'category_id.required' => 'Kategori produk wajib dipilih.',
            'name.required' => 'Nama produk wajib diisi.',
            'price.required' => 'Harga jual wajib diisi.',
            'purchase_price.required' => 'Harga modal wajib diisi.',
        ]);

        // Jika upload gambar baru, hapus gambar lama dulu
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(base_path($product->image))) {
                @unlink(base_path($product->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/products');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['image'] = 'public/uploads/products/' . $filename;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk & file fotonya
    public function destroy(Product $product)
    {
        if ($product->image && file_exists(base_path($product->image))) {
            @unlink(base_path($product->image));
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}

