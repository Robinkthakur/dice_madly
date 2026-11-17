<?php

namespace App\Filament\Traits;

trait HasRoleBasedAuthorization
{
    protected static function getAuthenticatedAdmin()
    {
        return auth('admin')->user() ?? auth()->user();
    }

    public static function canViewAny(): bool
    {
        $user = static::getAuthenticatedAdmin();
        return $user && in_array($user->role, ['Super Admin', 'Moderator', 'Support']);
    }

    public static function canCreate(): bool
    {
        $user = static::getAuthenticatedAdmin();
        return $user && in_array($user->role, ['Super Admin', 'Moderator']);
    }

    public static function canEdit($record): bool
    {
        $user = static::getAuthenticatedAdmin();
        return $user && in_array($user->role, ['Super Admin', 'Moderator']);
    }

    public static function canDelete($record): bool
    {
        $user = static::getAuthenticatedAdmin();
        return $user && $user->role === 'Super Admin';
    }
}
