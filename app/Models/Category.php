<?php

namespace App\Models;

use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = false;

    public function attributes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function hasProductsOrAChildCategoryHasProducts(): bool
    {
        $categoriesIds = $this->getIdsIncludingChildCategories();
        return (bool)Product::whereIn('category_id', $categoriesIds)->select('id')->first();
    }

    public function getMinAndMaxPrices(): array
    {
        $categoriesIds = $this->getIdsIncludingChildCategories();

        $minPrice = Product::whereIn('category_id', $categoriesIds)
            ->min('price');
        $maxPrice = Product::whereIn('category_id', $categoriesIds)
            ->max('price');

        return [
            'min' => floor($minPrice),
            'max' => ceil($maxPrice),
        ];
    }

    public function hasImage(): bool
    {
        return !empty($this->image);
    }

    public function getImageUrl(): string
    {
        return $this->image ? url('/storage/' . $this->image) : url(CategoryService::getPathToDefault());
    }

    public function parentCategoryId(): ?int
    {
        return Category::where('lft', '<', $this->lft)
            ->where('rgt', '>', $this->rgt)
            ->orderBy('rgt', 'asc')
            ->pluck('id')
            ->first();
    }

    public function previousCategoryId(): ?int
    {
        return Category::where('rgt', '=', $this->lft - 1)
            ->pluck('id')
            ->first();
    }

    public function childCategories(): Collection
    {
        return Category::where('lft', '>', $this->lft)
            ->where('rgt', '<', $this->rgt)
            ->select('id')
            ->get();
    }

    public function getIdsIncludingChildCategories(): array
    {
        return Category::where('lft', '>=', $this->lft)
            ->where('rgt', '<=', $this->rgt)
            ->pluck('id')
            ->toArray();
    }

    /**
     * Get all category attributes with measure units in titles
     * and all product values.
     */
    public function attributesWithUnitTitleAndValues(): array
    {
        $categoriesIds = implode(', ', $this->getIdsIncludingChildCategories());

        $attributes = DB::select(
            "SELECT a.id, CONCAT_WS(', ', a.title, m_u.title) AS title, GROUP_CONCAT(DISTINCT a_p.value)
                                                 AS product_values
                FROM attributes AS a LEFT JOIN measure_units AS m_u ON a.measure_unit_id = m_u.id
                LEFT JOIN attribute_product AS a_p ON a_p.attribute_id = a.id
                AND a_p.product_id IN (SELECT p.id FROM products AS p WHERE p.category_id IN ($categoriesIds))
                WHERE a.id IN (SELECT a_c.attribute_id FROM attribute_category AS a_c WHERE category_id = :id)
                GROUP BY a.id
                ORDER BY title", ['id' => $this->id]
        );
        return $this->convertAStringOfValuesToAnArray($attributes);
    }

    public function attributesIds(): array
    {
        return $this->attributes()
            ->pluck('id')
            ->toArray();
    }

    public function attributesIdsOfTheParentCategory(): array
    {
        $parentCategory = Category::where('lft', '<', $this->lft)
            ->where('rgt', '>', $this->rgt)
            ->orderBy('rgt', 'asc')
            ->select('id')
            ->first();

        return $parentCategory
            ? $parentCategory->attributesIds()
            : [];
    }

    private function convertAStringOfValuesToAnArray(array $attributes): array
    {
        foreach ($attributes as $attribute) {
            if (!empty($attribute->product_values)) {
                $attribute->values = explode(',', $attribute->product_values);
            } else {
                $attribute->values = null;
            }
            unset($attribute->product_values);
        }
        return $attributes;
    }
}
