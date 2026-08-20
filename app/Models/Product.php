<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Data Produk Koplink
class Product extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['category_id', 'name', 'description', 'price', 'purchase_price', 'image', 'stock'];

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Riwayat Transaksi Stok
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
}
