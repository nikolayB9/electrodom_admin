<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = false;

    public function parentCategoryId(): ?int
    {
        return Category::where('lft', '<', $this->lft)
            ->where('rgt', '>', $this->rgt)
            ->orderBy('rgt', 'asc')
            ->select('id')
            ->pluck('id')
            ->first();
    }

    public function previousCategoryId(): ?int
    {
        return Category::where('rgt', '=', $this->lft - 1)
            ->select('id')
            ->pluck('id')
            ->first();
    }

    public function getImageUrl(): ?string
    {
        return $this->image ? url('/storage/' . $this->image) : null;
    }

    public function attributes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
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

    public function attributesIdsOfTheParentCategory(): array
    {
        $parentCategory = Category::where('lft', '<', $this->lft)
            ->where('rgt', '>', $this->rgt)
            ->orderBy('rgt', 'asc')
            ->select('id')
            ->first();

        return $parentCategory
            ? $parentCategory->attributes()->select('id')->pluck('id')->toArray()
            : [];
    }

    public function childCategories(): Collection
    {
        return Category::where('lft', '>', $this->lft)
            ->where('rgt', '<', $this->rgt)
            ->select('id')
            ->get();
    }
}
