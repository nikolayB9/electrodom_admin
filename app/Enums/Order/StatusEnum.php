<?php

namespace App\Enums\Order;

enum StatusEnum: int
{
    case CREATED = 1;
    case PAID = 2;
    case SENT = 3;
    case RECEIVED = 4;
    case CANCELLED = 5;

    public static function getValuesWithNames(): array
    {
        $data = [];
        foreach (StatusEnum::cases() as $enum) {
            $data[] = [
              'value' => $enum->value,
              'name' => self::getName($enum),
            ];
        }
        return $data;
    }

    public static function getName(StatusEnum $status): string
    {
        return match ($status) {
            self::CREATED => 'создан',
            self::PAID => 'оплачен',
            self::SENT => 'отправлен',
            self::RECEIVED => 'получен',
            self::CANCELLED => 'отменен',
        };
    }
}




