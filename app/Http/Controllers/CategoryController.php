<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateAttributesRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use App\Services\AttributeService;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index()
    {
        return view('category.index', ['categories' => $this->categoryService->getWithLevels()]);
    }

    public function create()
    {
        return view('category.create', [
            'categories' => $this->categoryService->getWithLevels(),
            'imgParams' => $this->categoryService::getImgParams(),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $category = $this->categoryService->add($request->validated());
        return redirect()->route('categories.index')
            ->with('status', 'Категория "' . $category->title . '" успешно добавлена.');
    }

    public function edit(Category $category, AttributeService $attributeService)
    {
        return view('category.edit', [
            'category' => $category,
            'categories' => $this->categoryService->getWithLevels(),
            'imgParams' => $this->categoryService::getImgParams(),
            'parentCategoryId' => $category->parentCategoryId(),
            'previousCategoryId' => $category->previousCategoryId(),
            'attributes' => $attributeService->getWithUnitTitle(),
            'categoryAttributesIds' => $category->attributesIds(),
            'parentAttributesIds' => $category->attributesIdsOfTheParentCategory(),
        ]);
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $this->categoryService->change($category, $request->validated());
        return redirect()->route('categories.edit', $category->id)
            ->with('status', 'Категория успешно обновлена.');
    }

    public function updateAttributes(UpdateAttributesRequest $request, Category $category)
    {
        $this->categoryService->changeAttributes($category, $request->validated('attributes_ids'));
        return redirect()->route('categories.edit', $category->id)
            ->with('status', 'Атрибуты категории обновлены.');
    }

    public function destroy(Category $category)
    {
        if ($category->hasProductsOrAChildCategoryHasProducts()) {
            return back()->withErrors(['categoryDeletion' => 'You cannot delete a category "' . $category->title . '" that is used by at least one product']);
        }
        $this->categoryService->remove($category);
        return redirect()->route('categories.index')
            ->with('status', 'Категория "' . $category->title . '" удалена.');
    }
}
