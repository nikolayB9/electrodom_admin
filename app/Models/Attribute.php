<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $table = 'attributes';
    protected $guarded = false;

    public function measureUnit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MeasureUnit::class);
    }

    public function getFullTitle()
    {
        return $this->measure_unit_id ? $this->title . ', ' . $this->measureUnit->title : $this->title;
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function canBeDeleted(): bool
    {
        return !$this->categories()->first();
    }
}
