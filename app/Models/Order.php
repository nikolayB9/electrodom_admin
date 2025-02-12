<?php

namespace App\Models;

use App\Enums\Order\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['price', 'qty', 'total_price']);
    }

    protected $table = 'orders';
    protected $guarded = false;

    protected function casts(): array
    {
        return [
            'payment_status' => PaymentStatusEnum::class,
        ];
    }
}
