<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCanCreateProduct()
    {
        // Create a user and authenticate with Sanctum
        $user = User::factory()->create();

        $data = [
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 10.50,
            'stock' => 5,
            'category' => ['1']
        ];

        // Authenticate user using Sanctum
        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/product', $data);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Le produit a été créé avec succès']);

        $this->assertDatabaseHas('products', $data);
    }

    /** @test */
    public function itCanUpdateProduct()
    {
        // Create a user and authenticate with Sanctum
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $updatedData = [
            'name' => 'Updated Product',
            'price' => 20.00,
        ];

        // Authenticate user using Sanctum
        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/product/{$product->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Le produit a été mis à jour avec succès']);

        $this->assertDatabaseHas('products', $updatedData);
    }

    /** @test */
    public function itCanDeleteProduct()
    {
        // Create a user and authenticate with Sanctum
        $user = User::factory()->create();

        $product = Product::factory()->create();

        // Authenticate user using Sanctum
        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/product/{$product->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Le produit a été supprimé avec succès']);

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
