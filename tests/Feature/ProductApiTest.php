<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    private function authenticateUser()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        return $token;
    }

    public function test_can_fetch_products()
    {
        $token = $this->authenticateUser();
        Product::factory()->count(10)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson('/api/products');

        $response->assertStatus(200);
    }

    public function test_can_fetch_single_product()
    {
        $token = $this->authenticateUser();
        $product = Product::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson('/api/products/' . $product->id);

        $response->assertStatus(200);
    }

    public function test_can_create_product()
    {
        $token = $this->authenticateUser();
        $productData = [
            'title' => 'Test Product',
            'price' => 100,
            'quantity' => 5
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/products', $productData);

        $response->assertStatus(201);
    }

    public function test_can_update_product()
    {
        $token = $this->authenticateUser();
        $product = Product::factory()->create();
        $productData = [
            'title' => 'Updated Product',
            'price' => 150,
            'quantity' => 3
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson('/api/products/' . $product->id, $productData);

        $response->assertStatus(200);
    }

    public function test_can_delete_product()
    {
        $token = $this->authenticateUser();
        $product = Product::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(200);
    }
}
