<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRoleEnum: int
{
    case ROOT = 1;
    case ADMIN = 2;
    case MODERATOR = 3;
    case USER = 4;
}
