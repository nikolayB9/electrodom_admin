<?php

namespace App\Validation;

use App\Services\CategoryService;
use Illuminate\Validation\Validator;

class CheckingParentCategoryLevel
{
    public function __invoke(Validator $validator): void
    {
        $validated = $validator->validated();

        if (!empty($validated['parent_category'])) {
            $categoryService = new CategoryService();
            $levelParentCategory = $categoryService->getLevelById($validated['parent_category']);

            if ($levelParentCategory >= config('categories.max_nesting_level')) {
                $validator->errors()->add(
                    'parent_category',
                    'The parent category level must be less than the maximum nesting level'
                );
            }
        }
    }
}
