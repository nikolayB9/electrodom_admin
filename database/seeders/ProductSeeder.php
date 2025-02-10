<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private int $maxRandomProductsInCategory = 5;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ($this->getProductCategories() as $category) {
            $numberOfProductsInCategory = rand(1, $this->maxRandomProductsInCategory);
            $attributes = $category->attributes()->select('id')->get();
            $this->createCategoryProductsWithAttributes($category->id, $numberOfProductsInCategory, $attributes);
        }
    }

    private function getProductCategories(): Collection
    {
        $categoryService = new CategoryService();
        $categoriesIds = $categoryService->getLastNestingLevelCategories()->pluck('id')->toArray();
        return Category::whereIn('id', $categoriesIds)->select('id')->get();
    }

    private function createCategoryProductsWithAttributes(int        $categoryId,
                                                          int        $numberOfProducts,
                                                          Collection $attributes): void
    {
        while ($numberOfProducts > 0) {
            Product::factory()
                ->hasAttached($attributes, ['value' => fake()->randomElement([rand(1, 100), ucfirst(fake()->word)])])
                ->create([
                    'category_id' => $categoryId,
                ]);
            $numberOfProducts--;
        }
    }
}
