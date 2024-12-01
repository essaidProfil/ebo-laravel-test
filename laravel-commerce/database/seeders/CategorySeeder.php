<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Créez 5 catégories fictives
        Category::factory()->count(5)->create();
    }
}
