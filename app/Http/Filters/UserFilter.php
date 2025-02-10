<?php

namespace App\Http\Filters;

use App\Enums\User\OrderByEnum;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends AbstractFilter
{
    const NAME_OR_EMAIL = 'nameOrEmail';
    const ORDER_BY = 'orderBy';

    public function getCallbacks(): array
    {
        return [
            self::NAME_OR_EMAIL => [$this, 'nameOrEmail'],
            self::ORDER_BY => [$this, 'orderBy'],
        ];
    }

    protected function nameOrEmail(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    }

    protected function orderBy(Builder $builder, $value)
    {
        switch ($value) {
            case OrderByEnum::ID_ASC->value:
                $builder->orderBy('id');
                break;
            case OrderByEnum::ID_DESC->value:
                $builder->orderBy('id', 'desc');
                break;
            case OrderByEnum::EMAIL_A_Z->value:
                $builder->orderBy('email');
                break;
            case OrderByEnum::EMAIL_Z_A->value:
                $builder->orderBy('email', 'desc');
                break;
            case OrderByEnum::NAME_A_Z->value:
                $builder->orderBy('name');
                break;
            case OrderByEnum::NAME_Z_A->value:
                $builder->orderBy('name', 'desc');
                break;

        }
    }
}
