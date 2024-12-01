<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_category()
    {
        $data = ['name' => 'Test Category'];

        $response = $this->postJson('/api/categories', $data);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Category created successfully']);

        $this->assertDatabaseHas('categories', $data);
    }

    /** @test */
    public function it_can_list_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'created_at', 'updated_at'],
            ]);
    }
}
