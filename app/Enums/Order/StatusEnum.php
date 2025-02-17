<?php

namespace App\Enums\Order;

use App\Enums\Attributes\Description;
use App\Enums\Traits\GetsAttributes;


enum StatusEnum: int
{
    use GetsAttributes;

    #[Description('Создан')]
    case CREATED = 1;

    #[Description('Оплачен')]
    case PAID = 2;

    #[Description('Отправлен')]
    case SENT = 3;

    #[Description('Получен')]
    case RECEIVED = 4;

    #[Description('Отменен')]
    case CANCELLED = 5;
}




