<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';
    protected $guarded = false;

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function canBeDeleted(): bool
    {
        return !$this->orders()->first();
    }

    public function canBeChangedInTheOrder(Order $order): bool
    {
        return !$this->orders()->where('id', '!=', $order->id)->first();
    }
}
