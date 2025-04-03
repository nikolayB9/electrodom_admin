<?php

namespace App\Http\Filters;

use App\Enums\Product\OrderByEnum;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    const TITLE = 'title';
    const CATEGORY_ID = 'categoryId';
    const ATTRIBUTES = 'attributes';
    const PRICE_MIN = 'priceMin';
    const PRICE_MAX = 'priceMax';
    const ORDER_BY = 'orderBy';

    public function getCallbacks(): array
    {
        return [
            self::TITLE => [$this, 'title'],
            self::CATEGORY_ID => [$this, 'categoryId'],
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

    protected function categoryId(Builder $builder, $value)
    {
        $ids = Category::find($value)->getIdsIncludingChildCategories();
        $builder->whereIn('category_id', $ids);
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
            case OrderByEnum::PRICE_LOW_HIGH->value:
                $builder->orderBy('price');
                break;
            case OrderByEnum::PRICE_HIGH_LOW->value:
                $builder->orderBy('price', 'desc');
                break;
            case OrderByEnum::ID_ASC->value:
                $builder->orderBy('id');
                break;
            case OrderByEnum::ID_DESC->value:
                $builder->orderBy('id', 'desc');
                break;
        }
    }
}
