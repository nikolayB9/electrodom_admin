<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct(public CategoryService $categoryService)
    {
    }

    public function index()
    {
        $categories = $this->categoryService->getWithLevels();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->categoryService->getWithLevels();
        $imgParams = $this->categoryService->getImgParams();
        return view('category.create', compact('categories', 'imgParams'));
    }

    public function store(StoreRequest $request)
    {
        $category = $this->categoryService->add($request->validated());
        return redirect()->route('categories.index')
            ->with('status', 'Категория "' . $category->title . '" успешно добавлена.');
    }

    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $categories = $this->categoryService->getWithLevels();
        $imgParams = $this->categoryService->getImgParams();
        $parentCategoryId = $category->parentCategoryId();
        $previousCategoryId = $category->previousCategoryId();
        return view('category.edit', compact('category', 'categories',
            'imgParams', 'parentCategoryId', 'previousCategoryId'));
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $this->categoryService->change($category, $request->validated());
        return redirect()->route('categories.show', $category->id)->with('status', 'Категория успешно обновлена.');
    }

    public function destroy(Category $category)
    {
        $this->categoryService->remove($category);
        return redirect()->route('categories.index')
            ->with('status', 'Категория "' . $category->title . '" удалена.');
    }
}
