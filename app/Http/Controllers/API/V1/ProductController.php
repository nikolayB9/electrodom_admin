<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\API\V1\ProductService;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
    }

    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

}
