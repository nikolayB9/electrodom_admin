<?php

namespace App\Validation;

use App\Models\Category;
use Illuminate\Validation\Validator;

class CheckingPreviousAndParentCategoryHierarchy
{
    public function __invoke(Validator $validator): void
    {
        $validated = $validator->validated();

        if (!empty($validated['previous_category'])) {
            $previousCategory = Category::find($validated['previous_category']);

            if ($previousCategory->parentCategoryId() != $validated['parent_category']) {
                $validator->errors()->add(
                    'previous_category',
                    'The category must be a direct descendant of the parent category'
                );
            }
        }
    }
}
