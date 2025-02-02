<?php

namespace App\Services\API\V1;

use App\Models\Category;

class ProductService
{
    public function processTheDataForFiltering(array $data): array
    {
        if (!empty($data['categoryId'])) {
            $category = Category::find($data['categoryId']);
            unset($data['categoryId']);
            $data['categories'] = $category->getIdsIncludingChildCategories();
        }

        return $data;
    }
}
