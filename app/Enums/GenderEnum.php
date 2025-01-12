<?php

namespace App\Enums;

enum GenderEnum: string
{
    case Male = 'мужской';
    case Female = 'женский';
    case Unspecified = 'не указан';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
