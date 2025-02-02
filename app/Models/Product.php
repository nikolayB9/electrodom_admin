<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Filterable;

    protected $table = 'products';
    protected $guarded = false;

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Attribute::class)
            ->withPivot('value');
    }

    public function getCategoryTitle()
    {
        return $this->category()
            ->select('title')
            ->value('title');
    }

    public function getCategoryId()
    {
        return $this->category()
            ->select('id')
            ->value('id');
    }

    public function hasImage(): bool
    {
        return !empty($this->image);
    }

    public function getImageUrl(): string
    {
        return $this->image ? url('/storage/' . $this->image) : url(ProductService::getPathToDefault());
    }
}
