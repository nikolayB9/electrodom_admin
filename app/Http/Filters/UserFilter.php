<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter extends AbstractFilter
{
    const NAME_OR_EMAIL = 'nameOrEmail';

    public function getCallbacks(): array
    {
        return [
            self::NAME_OR_EMAIL => [$this, 'nameOrEmail'],
        ];
    }

    protected function nameOrEmail(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    }
}
