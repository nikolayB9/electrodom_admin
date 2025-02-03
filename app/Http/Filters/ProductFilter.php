<?php

namespace App\Http\Filters;

use App\Enums\Product\OrderByEnum;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    const TITLE = 'title';
    const CATEGORIES = 'categories';
    const ATTRIBUTES = 'attributes';
    const PRICE_MIN = 'priceMin';
    const PRICE_MAX = 'priceMax';
    const ORDER_BY = 'orderBy';

    public function getCallbacks(): array
    {
        return [
            self::TITLE => [$this, 'title'],
            self::CATEGORIES => [$this, 'categories'],
            self::PRICE_MIN => [$this, 'priceMin'],
            self::PRICE_MAX => [$this, 'priceMax'],
            self::ATTRIBUTES => [$this, 'attributes'],
            self::ORDER_BY => [$this, 'orderBy'],
        ];
    }

    protected function title(Builder $builder, $value)
    {
        $builder->where('title', 'like', "%{$value}%");
    }

    protected function categories(Builder $builder, $value)
    {
        $builder->whereIn('category_id', $value);
    }

    protected function attributes(Builder $builder, $value)
    {
        foreach ($value as $id => $values) {
            $builder->whereHas('attributes', function ($q) use ($id, $values) {
                $q->where('attribute_id', $id)
                    ->whereIn('value', $values);
            });
        }
    }

    protected function priceMin(Builder $builder, $value)
    {
        $builder->where('price', '>=', $value);
    }

    protected function priceMax(Builder $builder, $value)
    {
        $builder->where('price', '<=', $value);
    }

    protected function orderBy(Builder $builder, $value)
    {
        switch ($value) {
            case OrderByEnum::BY_DEFAULT->value:
                break;
            case OrderByEnum::NAME_A_Z->value:
                $builder->orderBy('title');
                break;
            case OrderByEnum::NAME_Z_A->value:
                $builder->orderBy('title', 'desc');
                break;
            case OrderByEnum::PRICE_L_H->value:
                $builder->orderBy('price');
                break;
            case OrderByEnum::PRICE_H_L->value:
                $builder->orderBy('price', 'desc');
                break;
        }
    }
}
