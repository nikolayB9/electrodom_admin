<?php

namespace App\Services;

use App\Models\MeasureUnit;
use Illuminate\Support\Facades\DB;

class AttributeService
{
    /**
     * Get all attributes with measure units in titles as fullTitle.
     */
    public function getWithFullTitle(): \Illuminate\Support\Collection
    {
        return DB::table('attributes')
            ->leftJoin('measure_units', 'attributes.measure_unit_id', '=', 'measure_units.id')
            ->select('attributes.id', 'attributes.title', 'attributes.measure_unit_id')
            ->selectRaw('CONCAT_WS(", ", attributes.title, measure_units.title) AS fullTitle')
            ->orderBy('attributes.title')
            ->get();
    }
}
