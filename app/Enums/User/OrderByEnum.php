<?php

namespace App\Enums\User;

use App\Enums\Attributes\Description;
use App\Enums\Traits\GetsAttributes;

enum OrderByEnum: string
{
    use GetsAttributes;

    #[Description('По возрастанию ID')]
    case ID_ASC = 'id_asc';

    #[Description('По убыванию ID')]
    case ID_DESC = 'id_desc';

    #[Description('a - z')]
    case EMAIL_A_Z = 'email_a_z';

    #[Description('z - a')]
    case EMAIL_Z_A = 'email_z_a';

    #[Description('а - я')]
    case NAME_A_Z = 'name_a_z';

    #[Description('я - а')]
    case NAME_Z_A = 'name_z_a';
}




