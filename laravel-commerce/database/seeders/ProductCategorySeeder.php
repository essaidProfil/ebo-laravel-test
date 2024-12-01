<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        $categories = Category::all();

        // Associe chaque produit à 1 à 3 catégories aléatoires
        foreach ($products as $product) {
            $product->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
