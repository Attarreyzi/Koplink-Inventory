<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Category::latest()->get()
        ]);
    }

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

    public function destroy(Category $category)
    {
        // Check if there are products using this category
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
