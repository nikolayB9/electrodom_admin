<?php

namespace App\Enums\Order;

use App\Enums\Attributes\Description;
use App\Enums\Traits\GetsAttributes;

enum OrderByEnum: string
{
    use GetsAttributes;

    #[Description('От новых к старым')]
    case DATE_NEW_OLD = 'date_new_old';

    #[Description('От старых к новым')]
    case DATE_OLD_NEW = 'date_old_new';

    #[Description('Увеличение стоимости')]
    case PRICE_LOW_HIGH = 'price_low_high';

    #[Description('Уменьшение стоимости')]
    case PRICE_HIGH_LOW = 'price_high_low';

    #[Description('Уменьшение ID')]
    case ID_DESC = 'id_desc';
}




