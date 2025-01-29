<?php

namespace App\Services\API\V1;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    public function getWithSubcategories(): Collection
    {
        $categories = Category::select('id', 'title', 'lft', 'rgt')->orderBy('lft')->get();
        return $this->sortCategories($categories);
    }

    public function sortCategories(Collection $categories): Collection
    {
        $collection = new Collection();
        $subCategories = new Collection();
        foreach ($categories as $category) {
            if (($category->rgt - $category->lft) != 1 && !$subCategories->contains($category)) {
                $subCategories = $categories->where('lft', '>', $category->lft)
                    ->where('rgt', '<', $category->rgt);
                $category->subCategories = $this->sortCategories($subCategories);
                $collection->push($category);
            } elseif (!$subCategories->contains($category)) {
                $collection->push($category);
            }
        }
        return $collection;
    }
}
