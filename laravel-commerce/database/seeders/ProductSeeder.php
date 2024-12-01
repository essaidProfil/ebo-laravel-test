<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Créez 10 produits fictifs
        Product::factory()->count(10)->create();
    }
}
