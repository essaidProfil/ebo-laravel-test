<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_attach_categories_to_a_product()
    {
        $product = Product::factory()->create();
        $categories = Category::factory()->count(2)->create();

        $response = $this->postJson("/api/products/{$product->id}/categories", [
            'categories' => $categories->pluck('id')->toArray(),
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Categories attached successfully']);

        $this->assertCount(2, $product->categories);
    }

    /** @test */
    public function it_can_list_products_by_category()
    {
        $category = Category::factory()->create();
        $products = Product::factory()->count(3)->create();
        $category->products()->attach($products->pluck('id'));

        $response = $this->getJson("/api/categories/{$category->id}/products");

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'description', 'price', 'stock'],
            ]);
    }
}
