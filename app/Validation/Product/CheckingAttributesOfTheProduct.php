<?php

namespace App\Validation\Product;

use Illuminate\Validation\Validator;

class CheckingAttributesOfTheProduct
{
    public function __invoke(Validator $validator): void
    {
        $validated = $validator->validated();
        $attributesIds = array_keys($validated['attributes_ids']);
        $productAttributesIds = request()->product->attributes()->select('id')->pluck('id')->toArray();

        if (count($attributesIds) !== count($productAttributesIds)) {
            $validator->errors()->add(
                'attributes_ids',
                'The attributes have not been edited: the number of attributes does not match.'
            );
            return;
        }


        foreach ($productAttributesIds as $attributeId) {
            if (!in_array($attributeId, $attributesIds)) {
                $validator->errors()->add(
                    'attributes_ids',
                    'The attributes have not been edited: not all product attributes were transmitted.'
                );
                return;
            }
        }
    }
}
