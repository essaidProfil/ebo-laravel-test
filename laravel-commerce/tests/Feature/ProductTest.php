<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCanCreateProduct()
    {
        $data = [
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 10.50,
            'stock' => 5,
            'category' => ['1']
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Le produit a été créé avec succès']);

        $this->assertDatabaseHas('products', $data);
    }

    /** @test */
    public function itCanUpdateProduct()
    {
        $product = Product::factory()->create();

        $updatedData = [
            'name' => 'Updated Product',
            'price' => 20.00,
        ];

        $response = $this->putJson("/api/products/{$product->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Le produit a été mis à jour avec succès']);

        $this->assertDatabaseHas('products', $updatedData);
    }

    /** @test */
    public function itCanDeleteProduct()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Le produit a été supprimé avec succès']);

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
