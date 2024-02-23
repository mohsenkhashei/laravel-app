<?php

namespace Tests\Unit;

use App\Http\Controllers\ProductsController;
use App\Http\Requests\StoreProductRequest;
use Mockery;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as IlluminateView;

//vendor/bin/phpunit --filter testIndexMethodReturnsView
//vendor/bin/phpunit tests/Unit/ProductsControllerTest.php

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;
    public $mockedView;


    public function testIndexMethodReturnsView()
    {
        // Arrange
        // Create some products to paginate
        $products = Product::factory()->count(10)->create();

        // Act
        // Call the index method
        $response = $this->get('/products');
        // Assert
        // Assert that the response is successful (status code 200)
        $response->assertStatus(200);
        echo "status 200 fetched \n";
        // Assert that the returned view is of type View
        $response->assertViewIs('products.index');

        // Assert that the view contains the products
        echo "view returned with data and pagination \n";
        $response->assertViewHas('products', function ($viewProducts) use ($products) {
            // Check if the paginated products are correct
            return $viewProducts->pluck('id')->diff($products->pluck('id'))->isEmpty();
        });
    }

    public function testCreateMethodReturnsView()
    {
        $response = $this->get('/products/create');
        $response->assertStatus(200);
        $response->assertViewIs('products.create');
        echo 'status 200 fetched \n';
    }

    public function testStoreMethodValidatesRequestAndCreatesProduct()
    {
        // Mock request data
        $request = new StoreProductRequest([
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.99
        ]);
       // Create an instance of the controller
       $controller = new ProductsController();

       // Call the store method with the real request object
       echo 'validate & store data \n';
       $response = $controller->store($request);

       // Assert that the response is a redirect
       $this->assertInstanceOf(RedirectResponse::class, $response);

       // Assert that the redirect points to the products index route
       $this->assertEquals(route('products.index'), $response->getTargetUrl());
       // Assert that the success message is flashed
       $this->assertStringContainsString('success', $response->getSession()->get('success'));
       echo 'redirect to index page & set success message \n';

    }


   public function testEditMethodReturnsViewWithProductData()
   {
        $t = Mockery::mock(IlluminateView::class);

        // Mock a Product instance
        $product = Mockery::mock(Product::class);

        // Set up expectations on the mocked view
        $product->shouldReceive('edit')->with($product)->andReturn($t);

        // Create an instance of the controller
        $controller = new ProductsController();

        // Call the edit method with the mocked Product
        $response = $controller->edit($product);

        // Assert that the response is a View instance
        $this->assertInstanceOf(IlluminateView::class, $response);
        echo 'redirect to edit page & set success message \n';
   }
}
