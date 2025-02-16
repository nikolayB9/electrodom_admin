<?php

namespace App\Http\Resources\User;

use App\Enums\User\GenderEnum;
use App\Http\Resources\Address\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
            'phone_number' => $this->phone_number,
            'gender' => GenderEnum::getName($this->gender),
            'address' => AddressResource::make($this->address),
        ];
    }
}
