<?php

namespace App\Enums\User;

enum GenderEnum: int
{
    case UNSPECIFIED = 0;
    case MALE = 1;
    case FEMALE = 2;

    public static function getValuesWithNames(): array
    {
        $data = [];
        foreach (GenderEnum::cases() as $enum) {
            $data[] = [
                'value' => $enum->value,
                'name' => self::getName($enum),
            ];
        }
        return $data;
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
