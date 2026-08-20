<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

// =======================================================
// Endpoint API Kategori - Koplink Inventory
// =======================================================
class CategoryApiController extends Controller
{
    // Daftar semua kategori
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Category::latest()->get()
        ]);
    }

    // Tambah kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $category
        ]);
    }

    // Update nama kategori
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil diperbarui',
            'data' => $category
        ]);
    }

    // Hapus kategori jika tidak terkait dengan produk
    public function destroy(Category $category)
    {
        // Cek jika kategori masih dipakai produk
        if ($category->products()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
}

