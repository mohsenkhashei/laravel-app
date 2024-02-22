<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product; // Import the Product model
use Illuminate\Support\Facades\DB; // Import the DB facade
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\Factory;

//vendor/bin/phpunit --filter testIndexMethodReturnsView
class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexMethodReturnsView()
    {
           // Arrange
        // Create some products to paginate
        $products = Product::factory()->count(10)->create();

        // Act
        // Call the index method
        $response = $this->get('/products');

        dd($response);
        // Assert
        // Assert that the response is successful (status code 200)
        $response->assertStatus(200);

        // Assert that the returned view is of type View
        $response->assertViewIs('products.index');

        // Assert that the view contains the products
        $response->assertViewHas('products', function ($viewProducts) use ($products) {
            // Check if the paginated products are correct
            return $viewProducts->pluck('id')->diff($products->pluck('id'))->isEmpty();
        });
    }
}
