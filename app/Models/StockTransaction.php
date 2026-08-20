<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Log Transaksi Mutasi Stok
class StockTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'type', 'quantity', 'note'];

    // Relasi ke Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

