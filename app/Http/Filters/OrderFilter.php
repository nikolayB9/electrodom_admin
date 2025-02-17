<?php

namespace App\Http\Filters;

use App\Enums\Order\OrderByEnum;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends AbstractFilter
{
    const DATE = 'date';
    const USER_ID = 'userId';
    const ORDER_BY = 'orderBy';

    public function getCallbacks(): array
    {
        return [
            self::DATE => [$this, 'date'],
            self::USER_ID => [$this, 'userId'],
            self::ORDER_BY => [$this, 'orderBy'],
        ];
    }

    protected function date(Builder $builder, $value)
    {
        $builder->where('created_at', 'like', "%{$value}%");
    }

    protected function userId(Builder $builder, $value)
    {
        $builder->where('user_id', $value);
    }

    protected function orderBy(Builder $builder, $value)
    {
        switch ($value) {
            case OrderByEnum::DATE_NEW_OLD->value:
                $builder->orderBy('created_at', 'desc');
                break;
            case OrderByEnum::DATE_OLD_NEW->value:
                $builder->orderBy('created_at');
                break;
            case OrderByEnum::PRICE_LOW_HIGH->value:
                $builder->orderBy('total_price');
                break;
            case OrderByEnum::PRICE_HIGH_LOW->value:
                $builder->orderBy('total_price', 'desc');
                break;
            case OrderByEnum::ID_DESC->value:
                $builder->orderBy('id', 'desc');
                break;
        }
    }
}
