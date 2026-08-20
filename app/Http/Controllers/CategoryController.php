<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

// =======================================================
// Controller Kategori Produk - Koplink Inventory
// =======================================================
class CategoryController extends Controller
{
    // Ambil semua daftar kategori beserta jumlah produknya
    public function index()
    {
        $categories = Category::with('products')->withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Form buat kategori baru
    public function create()
    {
        return view('admin.categories.create');
    }

    // Simpan kategori baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Kategori ini sudah tersedia.',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Hapus kategori jika tidak dipakai oleh produk
    public function destroy(Category $category)
    {
        // Proteksi: jangan hapus kategori jika masih ada produk terkait
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}

