<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Data Kategori Produk
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relasi ke Produk (One to Many)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

