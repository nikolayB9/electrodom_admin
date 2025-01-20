<?php

namespace App\Models;

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
}
