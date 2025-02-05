<?php

namespace App\Enums\User;

enum GenderEnum: string
{
    case Unspecified = 'не указан';
    case Male = 'мужской';
    case Female = 'женский';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
