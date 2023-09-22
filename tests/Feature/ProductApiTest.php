<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_products()
    {
        Product::factory()->count(10)->create();
        $response = $this->getJson('/api/products');
        $response->assertStatus(200);
    }

    public function test_can_fetch_single_product()
    {
        $product = Product::factory()->create();
        $response = $this->getJson('/api/products/' . $product->id);
        $response->assertStatus(200);
    }

    public function test_can_create_product()
    {
        $productData = [
            'title' => 'Test Product',
            'price' => 100,
            'quantity' => 5
        ];
        $response = $this->postJson('/api/products', $productData);
        $response->assertStatus(201);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();
        $productData = [
            'title' => 'Updated Product',
            'price' => 150,
            'quantity' => 3
        ];
        $response = $this->putJson('/api/products/' . $product->id, $productData);
        $response->assertStatus(200);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();
        $response = $this->deleteJson('/api/products/' . $product->id);
        $response->assertStatus(200);
    }
}
