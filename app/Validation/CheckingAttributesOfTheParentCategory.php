<?php

namespace App\Validation;

use App\Services\CategoryService;
use Illuminate\Validation\Validator;

class CheckingAttributesOfTheParentCategory
{
    public function __invoke(Validator $validator): void
    {
        $validated = $validator->validated();
        $parentAttributeIds = request()->category->attributesIdsOfTheParentCategory();

        foreach ($parentAttributeIds as $attributeId) {
            if (!in_array((string)$attributeId, $validated['attributes_ids'])) {
                $validator->errors()->add(
                    'attributes_ids',
                    'The attributes have not been edited: the category must have all the attributes of the parent category!'
                );
                return;
            }
        }
    }
}
