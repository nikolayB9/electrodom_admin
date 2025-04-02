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
            ->select('attributes.id', 'attributes.title')
            ->selectRaw('measure_units.id as measureUnitId')
            ->selectRaw('CONCAT_WS(", ", attributes.title, measure_units.title) AS fullTitle')
            ->orderBy('attributes.title')
            ->get();
    }

    public function processMeasureUnit(array $data): ?int
    {
        if (!empty($data['measure_unit_id'])) {
            return $data['measure_unit_id'];
        }

        if (!empty($data['new_measure_unit'])) {
            return MeasureUnit::create([
                'title' =>  $data['new_measure_unit'],
            ])->id;
        }

        return null;
    }
}
