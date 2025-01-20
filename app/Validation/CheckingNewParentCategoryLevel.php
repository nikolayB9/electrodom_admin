<?php

namespace App\Validation;

use App\Services\CategoryService;
use Illuminate\Validation\Validator;

class CheckingNewParentCategoryLevel
{
    public function __invoke(Validator $validator): void
    {
        $validated = $validator->validated();
        $category = request()->category;

        if (!empty($validated['parent_category']) && $validated['parent_category'] != $category->parentCategoryId()) {
            $categoryService = new CategoryService();
            $parentCategoryLevel = $categoryService->getLevelById($validated['parent_category']);

            if ($parentCategoryLevel >= $categoryService->getLevelById($category->id)) {
                $validator->errors()->add(
                    'parent_category',
                    'The nesting level of the parent category must be LESS than the level of the category being modified.'
                );
            }
        }
    }
}
