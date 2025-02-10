<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasureUnit extends Model
{
    use HasFactory;

    protected $table = 'measure_units';
    protected $guarded = false;

    public function attributes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attribute::class, 'measure_unit_id', 'id');
    }

    public function belongsToTheAttribute(): bool
    {
        return (bool)$this->attributes()->select('id')->first();
    }
}
