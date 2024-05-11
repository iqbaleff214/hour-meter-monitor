<?php

namespace App\Enum;

enum Role: string
{
    case PARENT_COMPANY = 'parent';
    case SUBSIDIARY = 'subsidiary';
}
