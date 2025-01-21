<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeasureUnit extends Model
{
    protected $table = 'measure_units';
    protected $guarded = false;

    public function canBeDeleted(): bool
    {
        return empty(Attribute::where('measure_unit_id', $this->id)->first());
    }
}
