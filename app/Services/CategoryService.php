<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService extends ImageHandlerService
{
    /**
     * Get all categories with nesting levels.
     */
    public function getWithLevels(): \Illuminate\Support\Collection
    {
        $categories = DB::select(
            'SELECT child.id, child.title, (COUNT(parent.id) - 1) AS level
            FROM categories AS child,
                 categories AS parent
            WHERE child.lft BETWEEN parent.lft AND parent.rgt
            GROUP BY child.id
            ORDER BY child.lft'
        );

        return collect($categories);
    }

    /**
     * Get the nesting level of a category by id.
     */
    public function getLevelById(int $categoryId): ?int
    {
        return DB::scalar('SELECT (COUNT(parent.id) - 1)
                        FROM categories AS parent, categories as child
                        WHERE child.lft BETWEEN parent.lft AND parent.rgt
                        AND child.id = :id', ['id' => $categoryId]);
    }

    public function add(array $data): Category
    {
        $data = $this->processImageSaving($data);

        /* The value after which we insert the category */
        $before = $this->findTheValueBeforeInserting($data);

        return DB::transaction(function () use ($before, $data) {
            /* Moving all lft and rgt to the right of the value (freeing up space for inserting the category) */
            $this->doIncrementLftAndRgt($before, 2);

            /* Inserting a new category into the vacated space */
            return Category::create([
                'title' => $data['title'],
                'lft' => $before + 1,
                'rgt' => $before + 2,
                'image' => $data['image'] ?? null,
            ]);
        });
    }

    public function change(Category $category, array $data): void
    {
        $data = $this->processImageUpdating($category, $data);

        $category->update([
           'title' => $data['title'],
           'image' => $data['image'],
        ]);

        if ($category->parentCategoryId() == $data['parent_category']
            && $category->previousCategoryId() == $data['previous_category']) {
            return;
        }

        /* The value after which we insert the category */
        $before = $this->findTheValueBeforeInserting($data);

        DB::transaction(function () use ($before, $category, $data) {
            $width = $category->rgt - $category->lft + 1;

            /* Moving all lft and rgt to the right of the value (freeing up space for inserting the category) */
            $this->doIncrementLftAndRgt($before, $width);

            $category->refresh();
            $right = $category->rgt;
            $offset = $before - $category->lft + 1;

            /* Inserting a category into the vacated space */
            Category::where('lft', '>=', $category->lft)
                ->where('rgt', '<=', $category->rgt)
                ->incrementEach(['lft' => $offset, 'rgt' => $offset]);

            /* Reducing all lft and rgt values to the right of the previous category placement */
            /* (compensating for moving the category) */
            $this->doDecrementLftAndRgt($right, $width);
        });
    }

    public function remove(Category $category): void
    {
        if (!empty($category->image)) {
            $this->deleteFromDisk($category->image);
        }

        DB::transaction(function () use ($category) {
            $left = $category->lft;
            $right = $category->rgt;

            $category->delete();

            /* Reducing lft and rgt in child categories */
            if ($right - $left > 1) {
                Category::where('lft', '>', $left)
                    ->where('rgt', '<', $right)
                    ->decrementEach(['lft' => 1, 'rgt' => 1]);
            }

            /* Reducing lft and rgt of the categories on the right */
            $this->doDecrementLftAndRgt($right, 2);
        });
    }

    public function getPathToSave(): string
    {
        return config('images.category.path_to_save');
    }

    public function getImgParams(): array
    {
        return config('images.category');
    }

    /**
     * The value after which we insert the category.
     */
    private function findTheValueBeforeInserting(array $data): int
    {
        if (!empty($data['previous_category'])) {
            $before = Category::find($data['previous_category'])->rgt;
        } elseif (!empty($data['parent_category'])) {
            $before = Category::find($data['parent_category'])->lft;
        } else {
            $min = Category::min('lft');
            $before = !empty($min) ? $min - 1 : 0;
        }

        return $before;
    }

    private function processImageSaving(array $data): array
    {
        if (!empty($data['image'])) {
            $data['image'] = $this->saveToDisk($data['image']);
        }
        return $data;
    }

    private function processImageUpdating(Category $category, array $data): array
    {
        if (!empty($data['image'])) {
            if (!empty($category->image)) {
                $this->deleteFromDisk($category->image);
            }
            $data['image'] = $this->saveToDisk($data['image']);
        } elseif (!empty($data['delete_image'])) {
            if (!empty($category->image)) {
                $this->deleteFromDisk($category->image);
            }
            $data['image'] = null;
        } else {
            $data['image'] = $category->image;
        }
        return $data;
    }

    /**
     * Increment all lft and rgt
     */
    private function doIncrementLftAndRgt(int $since, int $size): void
    {
        Category::where('lft', '>', $since)
            ->increment('lft', $size);

        Category::where('rgt', '>', $since)
            ->increment('rgt', $size);
    }

    /**
     * Decrement all lft and rgt
     */
    private function doDecrementLftAndRgt(int $since, int $size): void
    {
        Category::where('lft', '>', $since)
            ->decrement('lft', $size);

        Category::where('rgt', '>', $since)
            ->decrement('rgt', $size);
    }
}
