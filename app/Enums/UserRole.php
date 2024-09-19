<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Merchant = 'merchant';
    case User = 'user';
}
