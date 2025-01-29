<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\IndexCategoryResource;
use App\Models\Category;
use App\Services\API\V1\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index()
    {
        return IndexCategoryResource::collection($this->categoryService->getWithSubcategories());
    }
}
