<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function itCanAttachCategoriesToProduct()
    {
        // Create a user and authenticate using Sanctum
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum'); // Authenticate the user

        $product = Product::factory()->create();
        $categories = Category::factory()->count(2)->create();

        // Attach categories to the product
        $response = $this->postJson("/api/products/{$product->id}/categories", [
            'categories' => $categories->pluck('id')->toArray(),
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Categories attached successfully']);

        $this->assertCount(2, $product->categories);
    }

    public function itCanListProductsByCategory()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum'); // Authentifier l'utilisateur

        $category = Category::factory()->create();
        $products = Product::factory()->count(3)->create();
        $category->products()->attach($products->pluck('id'));

        // Lister les produits par categorie
        $response = $this->getJson("/api/categories/{$category->id}/products");

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'description', 'price', 'stock'],
            ]);
    }
}
