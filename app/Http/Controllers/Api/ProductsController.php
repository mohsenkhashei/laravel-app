<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductsResource;
use App\Models\Product;


class ProductsController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Return all products
     */
    public function index()
    {
//        return Product::latest()->paginate(5);
        return ProductsResource::collection(Product::all());
    }


    /**
     * create new product
     *
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return ProductsResource::make($product);
    }

    /**
     * show specific product
     *
     */
    public function show(Product $product)
    {
        return ProductsResource::make($product);
    }


    /**
     * Update the specific product
     *
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return ProductsResource::make($product);
    }

    /**
     * Remove the specific product
     *
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
    
}
