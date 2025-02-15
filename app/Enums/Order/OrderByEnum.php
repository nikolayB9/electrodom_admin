<?php

namespace App\Enums\Order;

enum OrderByEnum: string
{
    case DATE_NEW_OLD = 'От новых к старым';
    case DATE_OLD_NEW = 'От старых к новым';
    case PRICE_L_H = 'Увеличение стоимости';
    case PRICE_H_L = 'Уменьшение стоимости';
    case ID_DESC = 'Уменьшение ID';
}




