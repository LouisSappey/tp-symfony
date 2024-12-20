<?php

declare(strict_types=1);

namespace App\Enum;

enum UserAccountStatusEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case BANNED = 'banned';
}