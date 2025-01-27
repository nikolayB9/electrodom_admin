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
        $categoriesIds = Category::where('lft', '>=', $this->lft)
            ->where('rgt', '<=', $this->rgt)
            ->pluck('id')
            ->toArray();

        return (bool)Product::whereIn('category_id', $categoriesIds)->select('id')->first();
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

    /**
     * Get all category attributes with measure units in titles as fullTitle.
     */
    public function attributesWithUnitTitle(): \Illuminate\Support\Collection
    {
        $attributes = DB::select(
            'SELECT a.id, CONCAT_WS(", ", a.title, m_u.title) AS fullTitle
            FROM attributes AS a LEFT JOIN measure_units AS m_u ON a.measure_unit_id = m_u.id
            WHERE a.id IN (SELECT a_c.attribute_id FROM attribute_category AS a_c WHERE category_id = :id)
            ORDER BY a.title', ['id' => $this->id]
        );

        return collect($attributes);
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
}
