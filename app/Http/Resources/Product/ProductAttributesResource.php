<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => !empty($this->measureUnit)
                ? $this->title . ', ' . $this->measureUnit->title
                : $this->title,
            'value' => $this->pivot->value,
        ];
    }
}
