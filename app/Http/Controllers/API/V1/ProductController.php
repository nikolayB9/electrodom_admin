<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\API\V1\Product\IndexRequest;
use App\Http\Resources\Product\IndexProductResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\API\V1\ProductService;

class ProductController extends Controller
{
    public function index(IndexRequest $request, \App\Services\ProductService $productService)
    {
        $data = $productService->processTheDataForFiltering($request->validated());

        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($data)]);
        $products = Product::filter($filter)->paginate($data['showBy'], ['*'], 'page', $data['page']);

        return IndexProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

}
