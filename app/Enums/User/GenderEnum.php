<?php

namespace App\Enums\User;

enum GenderEnum: int
{
    case UNSPECIFIED = 0;
    case MALE = 1;
    case FEMALE = 2;

    public static function getValuesWithNames(): array
    {
        return [
            ['value' => self::UNSPECIFIED->value, 'name' => self::getName(self::UNSPECIFIED)],
            ['value' => self::MALE->value, 'name' => self::getName(self::MALE)],
            ['value' => self::FEMALE->value, 'name' => self::getName(self::FEMALE)],
        ];
    }

    public static function getName(GenderEnum $gender): string
    {
        return match ($gender) {
            self::UNSPECIFIED => 'не указан',
            self::MALE => 'мужской',
            self::FEMALE => 'женский',
        };
    }
}
