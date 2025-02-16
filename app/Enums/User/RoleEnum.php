<?php

namespace App\Enums\User;

enum RoleEnum: int
{
    case USER = 1;
    case ADMIN = 2;

    public static function getValuesWithNames(): array
    {
        return [
            ['value' => self::USER->value, 'name' => self::getName(self::USER)],
            ['value' => self::ADMIN->value, 'name' => self::getName(self::ADMIN)],
        ];
    }

    public static function getName(RoleEnum $role): string
    {
        return match ($role) {
            self::USER => 'покупатель',
            self::ADMIN => 'администратор',
        };
    }
}
