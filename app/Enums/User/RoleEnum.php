<?php

namespace App\Enums\User;

enum RoleEnum: int
{
    case USER = 1;
    case ADMIN = 2;

    public static function getValuesWithNames(): array
    {
        $data = [];
        foreach (RoleEnum::cases() as $enum) {
            $data[] = [
                'value' => $enum->value,
                'name' => self::getName($enum),
            ];
        }
        return $data;
    }

    public static function getName(RoleEnum $role): string
    {
        return match ($role) {
            self::USER => 'покупатель',
            self::ADMIN => 'администратор',
        };
    }
}
