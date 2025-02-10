<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private int $lft = 1;
    private int $numberOfInitialCategories = 3;
    private int $maxRandomSubcategories = 4;
    private int $maxRandomAttributes = 4;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $numberOfNestingLevels = config('categories.max_nesting_level')
            - config('categories.starting_level');
        $attributesIds = Attribute::pluck('id')->toArray();

        $this->createCategories($numberOfNestingLevels,
            $attributesIds,
            $this->lft,
            $this->numberOfInitialCategories,
            $this->maxRandomSubcategories,
            $this->maxRandomAttributes);
    }

    private function createCategories(int        $nestingLevel,
                                      array      $attributesIds,
                                      int        $lft,
                                      int        $numberOfCategories,
                                      int        $maxRandomSubcategories,
                                      int        $maxRandomAttributes,
                                      Collection $attributes = new Collection()): int
    {
        $rgt = null;

        for ($i = 0; $i < $numberOfCategories; $i++) {
            if ($nestingLevel > 0) {
                $categoryAttributes = $this->getRandomAttributesWithMerge($attributes, $attributesIds, $maxRandomAttributes);

                $rgt = $this->createCategories($nestingLevel - 1,
                    $attributesIds,
                    $lft + 1,
                    rand(1, $maxRandomSubcategories),
                    $maxRandomSubcategories,
                    $maxRandomAttributes,
                    $categoryAttributes);

                $this->createCategoryWithAttributes($categoryAttributes, $lft, $rgt);
            } else {
                $rgt = $lft + 1;
                $this->createCategoryWithAttributes($attributes, $lft, $rgt);
            }
            $lft = $rgt + 1;
        }
        return $rgt + 1;
    }

    private function getRandomAttributesWithMerge(Collection $attributes,
                                                  array      $attributesIds,
                                                  int        $maxRandomAttributes): Collection
    {
        $randAttributesIds = fake()->randomElements($attributesIds, rand(0, $maxRandomAttributes));
        $randAttributes = Attribute::whereIn('id', $randAttributesIds)
            ->select('id')
            ->get();
        return $attributes->merge($randAttributes);
    }

    private function createCategoryWithAttributes(Collection $attributes, int $lft, int $rgt): void
    {
        Category::factory()
            ->hasAttached($attributes)
            ->create([
                'lft' => $lft,
                'rgt' => $rgt,
            ]);
    }
}
