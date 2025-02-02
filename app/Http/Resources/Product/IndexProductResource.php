<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\MinifiedCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexProductResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->getImageUrl(),
            'price' => $this->price,
            'old_price' => $this->old_price,
        ];
    }
}
