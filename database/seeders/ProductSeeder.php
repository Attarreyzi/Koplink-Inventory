<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'category_id' => 1, // Coffee
            'name' => 'Espresso Hot',
            'description' => 'Kopi hitam murni panas.',
            'price' => 15000,
            'image' => null
        ]);

        Product::create([
            'category_id' => 2, // Non Coffee
            'name' => 'Chocolate Ice',
            'description' => 'Cokelat dingin premium.',
            'price' => 20000,
            'image' => null
        ]);
    }
}
