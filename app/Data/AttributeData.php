<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class AttributeData extends Data
{
    public function __construct(
        public string $title,
        public ?int   $measure_unit_id,
    )
    {
    }
}
