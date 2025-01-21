<?php

namespace App\Services;

use App\Models\MeasureUnit;
use Illuminate\Support\Facades\DB;

class AttributeService
{
    /**
     * Get all attributes with measure units in titles as fullTitle.
     */
    public function getWithUnitTitle(): \Illuminate\Support\Collection
    {
        $attributes = DB::select(
            'SELECT a.id, CONCAT_WS(", ", a.title, m_u.title) AS fullTitle
            FROM attributes AS a LEFT JOIN measure_units AS m_u ON a.measure_unit_id = m_u.id
            ORDER BY a.title'
        );

        return collect($attributes);
    }

    public function processNewMeasureUnit(array $data): array
    {
        if (!empty($data['new_measure_unit'])) {
            $measureUnit = MeasureUnit::create([
                'title' =>  $data['new_measure_unit'],
            ]);
            $data['measure_unit_id'] = $measureUnit->id;
        }
        unset($data['new_measure_unit']);
        return $data;
    }
}
