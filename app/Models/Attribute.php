<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';
    protected $guarded = false;

    public function measureUnit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MeasureUnit::class);
    }

    public function measureUnitId(): ?int
    {
        return $this->measureUnit->id ?? null;
    }

    public function fullTitle()
    {
        return $this->measureUnit ? $this->title . ', ' . $this->measureUnit->title : $this->title;
    }
}
