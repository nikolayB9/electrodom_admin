<?php

namespace App\Enums\User;

use App\Enums\Attributes\Description;
use App\Enums\Traits\GetsAttributes;

enum RoleEnum: int
{
    use GetsAttributes;

    #[Description('Покупатель')]
    case USER = 1;

    #[Description('Администратор')]
    case ADMIN = 2;
}
