<?php

namespace App\Enums\Product;

enum OrderByEnum: string
{
    case BY_DEFAULT = 'По умолчанию';
    case PRICE_L_H = 'Увеличение цены';
    case PRICE_H_L = 'Уменьшение цены';
    case NAME_A_Z = 'Название (а - я)';
    case NAME_Z_A = 'Название (я - а)';
    case ID_ASC = 'По возрастанию ID';
    case ID_DESC = 'По убыванию ID';
}




