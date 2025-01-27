<?php

namespace App\Validation\Category;

use Illuminate\Validation\Validator;

class CheckingAttributesOfTheParentCategory
{
    public function __invoke(Validator $validator): void
    {
        $validated = $validator->validated();
        $parentAttributesIds = request()->category->attributesIdsOfTheParentCategory();

        foreach ($parentAttributesIds as $attributeId) {
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
