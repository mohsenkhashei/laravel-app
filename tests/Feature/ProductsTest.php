<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
    }

    public function test_homepage_contains_product_table(): void
    {
        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
    }

    public function test_homepage_contains_non_empty_table(): void
    {
        $response = $this->actingAs($this->user)->get('/products');
        $product = Product::create([
            'name' => 'product 1',
            'description' => 'product 1 description',
            'price' => 1230
        ]);

        $response->assertViewHas('products', function ($collection) use ($product) {
            return !$collection->contains($product);
        });
    }

    public function test_can_see_the_product(): void
    {
        $product = Product::factory()->create();
        $response = $this->actingAs($this->user)->get('/products/' . $product->id);

        $response->assertStatus(200);
    }

    public function test_can_access_product_create_page()
    {
        $response = $this->actingAs($this->user)->get('/products/create');
        $response->assertStatus(200);
    }

    public function test_create_product_successful()
    {
        $productData = [
            'name' => 'sample product',
            'description' => 'test product',
            'price' => 2000
        ];

        $response = $this->actingAs($this->user)->post('/products', $productData);
        $this->assertDatabaseHas('products', $productData);
        $lastProduct = Product::latest()->first();
        $this->assertEquals($productData['name'], $lastProduct->name);
        $this->assertEquals($productData['description'], $lastProduct->description);
        $this->assertEquals($productData['price'], $lastProduct->price);

        $response->assertStatus(302);
        $response->assertRedirect('products');
        $response->assertSessionHas('success', 'Product created successfully.');
    }

    public function test_create_product_not_successful()
    {
        $response = $this->actingAs($this->user)->post('/products', []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
        $response->assertInvalid(['name', 'description']);
    }


    public function test_product_edit_contains_correct_values()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->get('products/edit/' . $product->id);
        $response->assertStatus(200);
        $response->assertSee('value="' . $product->name . '"', false);
        $response->assertSee('value="' . $product->description . '"', false);
        $response->assertSee('value="' . $product->price . '"', false);
        $response->assertViewHas('product', $product);
    }

    public function test_product_update_validation_error_redirects_back_to_form()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->put('products/update/' . $product->id, [
            'name' => '',
            'price' => 123
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
        $response->assertInvalid(['name']);
    }

    public function test_product_delete_successful()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->delete('products/' . $product->id);
        $response->assertRedirect('products');
        $this->assertDatabaseMissing('products', $product->toArray());
        $this->assertDatabaseCount('products', 0);
    }

    public function test_paginated_products_table_doesnt_contain_11th_record()
    {
        $products = Product::factory(11)->create();
        $lastProduct = $products->last();

        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertViewHas('products', function ($collection) use ($lastProduct) {
            return !$collection->contains($lastProduct);
        });

    }

    private function createUser(): User
    {
        return User::factory()->create();
    }

}
