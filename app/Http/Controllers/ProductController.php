<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\Product\IndexRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateAttributesRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(private ProductService  $productService,
                                private CategoryService $categoryService)
    {
    }

    public function index(IndexRequest $request,)
    {
        $data = $this->productService->processTheDataForFiltering($request->validated());

        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($data)]);
        $products = Product::filter($filter)->with('category')->paginate(15);

        return view('product.index', [
            'products' => $products,
            'categories' => $this->categoryService->getLastNestingLevelCategories(),
        ]);
    }

    public function create()
    {
        return view('product.create', [
            'categories' => $this->categoryService->getLastNestingLevelCategories(),
            'imgParams' => $this->productService::getImgParams(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $product = $this->productService->add($request->validated());
        return redirect()->route('products.show', $product->id)->with('status', 'Продукт успешно добавлен.');
    }

    public function edit(Product $product)
    {
        return view('product.edit', [
            'product' => $product,
            'categories' => $this->categoryService->getLastNestingLevelCategories(),
            'attributes' => $this->productService->getAttributesWithUnitTitle($product->id),
            'imgParams' => $this->productService::getImgParams(),
        ]);
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $this->productService->change($product, $request->validated());
        return redirect()->route('products.edit', $product->id)->with('status', 'Данные продукта обновлены.');
    }

    public function updateAttributes(UpdateAttributesRequest $request, Product $product)
    {
        $this->productService->changeAttributesValues($product, $request->validated());
        return redirect()->back()->with('status', 'Значения атрибутов обновлены.');
    }

    public function destroy(Product $product)
    {
        $this->productService->remove($product);
        return redirect()->route('products.index')
            ->with('status', 'Продукт "' . $product->title . '" удален.');
    }
}
