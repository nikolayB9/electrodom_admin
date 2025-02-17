<?php

namespace App\Enums\User;

use App\Enums\Attributes\Description;
use App\Enums\Traits\GetsAttributes;

enum GenderEnum: int
{
    use GetsAttributes;

    #[Description('Не указан')]
    case UNSPECIFIED = 0;

    #[Description('Мужской')]
    case MALE = 1;

    #[Description('Женский')]
    case FEMALE = 2;
}
