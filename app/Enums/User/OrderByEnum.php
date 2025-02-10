<?php

namespace App\Enums\User;

enum OrderByEnum: string
{
    case ID_ASC = 'По возрастанию';
    case ID_DESC = 'По убыванию';
    case EMAIL_A_Z = 'a - z';
    case EMAIL_Z_A = 'z - a';
    case NAME_A_Z = 'а - я';
    case NAME_Z_A = 'я - а';
}




