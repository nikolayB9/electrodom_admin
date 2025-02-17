<?php

namespace App\Enums\Product;

use App\Enums\Attributes\Description;
use App\Enums\Traits\GetsAttributes;

enum OrderByEnum: string
{
    use GetsAttributes;

    #[Description('По умолчанию')]
    case BY_DEFAULT = 'by_default';

    #[Description('Увеличение цены')]
    case PRICE_LOW_HIGH = 'price_low_high';

    #[Description('Уменьшение цены')]
    case PRICE_HIGH_LOW = 'price_high_low';

    #[Description('Название (а - я)')]
    case NAME_A_Z = 'name_a_z';

    #[Description('Название (я - а)')]
    case NAME_Z_A = 'name_z_a';

    #[Description('По возрастанию ID')]
    case ID_ASC = 'id_asc';

    #[Description('По убыванию ID')]
    case ID_DESC = 'id_desc';
}




