<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateAttributesRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(public ProductService $productService)
    {
    }

    public function index()
    {
        return view('product.index', ['products' => Product::with('category')->get()]);
    }

    public function create(CategoryService $categoryService)
    {
        return view('product.create', [
            'categories' => $categoryService->getLastNestingLevelCategories(),
            'imgParams' => $this->productService::getImgParams(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $product = $this->productService->add($request->validated());
        return redirect()->route('products.show', $product->id)->with('status', 'Продукт успешно добавлен.');
    }

    public function edit(Product $product, CategoryService $categoryService)
    {
        return view('product.edit', [
            'product' => $product,
            'categories' => $categoryService->getLastNestingLevelCategories(),
            'attributes' =>  $this->productService->getAttributesWithUnitTitle($product->id),
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
