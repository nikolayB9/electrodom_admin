<?php

namespace App\Models;

use App\Enums\Order\StatusEnum;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use Filterable, SoftDeletes;

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['price', 'qty', 'total_price']);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function getStatusName(): string
    {
        return StatusEnum::getDescription($this->status);
    }

    public function getFullAddress(): string
    {
        $address = $this->address;
        $city = 'г.' . $address->city;
        $street = $address->street ? ', ул.' . $address->street : null;
        $house = $address->house ? ', д.' . $address->house : null;
        $flat = $address->flat ? ', кв.' . $address->flat : null;

        return $city . $street . $house . $flat;
    }

    protected $table = 'orders';
    protected $guarded = false;

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => \Illuminate\Support\Carbon::create($value)->format('d.m.Y'),
        );
    }

    protected function casts(): array
    {
        return [
            'status' => StatusEnum::class,
        ];
    }
}
