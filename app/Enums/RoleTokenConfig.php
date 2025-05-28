<?php

namespace App\Enums;

class RoleTokenConfig
{
    public static function getTokenName(UserRole $role): string
    {
        return match ($role) {
            UserRole::ADMIN => 'admin-token',
            UserRole::USER => 'user-token',
        };
    }

    public static function getAbilities(UserRole $role): array
    {
        return match ($role) {
            UserRole::ADMIN => ['*'],
            UserRole::USER => [
                'invoice:read',
                'invoice:create',
                'customer:create',
            ]
        };
    }
}
