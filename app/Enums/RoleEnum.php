<?php

namespace App\Enums;

enum RoleEnum: string
{
    /**
     * Acceptable gender values.
     */
    case SUPERADMIN = 'superadmin';
    case SUPPORT = 'support';
    case ADMIN = 'admin';
    case HEADTEACHER = 'headteacher';

    /**
     * @return array<string>
     */
    public static function getRoles(): array
    {
        return array_map(fn ($roles) => $roles->value, self::cases());
    }
}
