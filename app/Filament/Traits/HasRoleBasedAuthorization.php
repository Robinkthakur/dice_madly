<?php

namespace App\Filament\Traits;

trait HasRoleBasedAuthorization
{
    public static function canViewAny(): bool
    {
        return auth()->user() && in_array(auth()->user()->role, ['Super Admin', 'Moderator', 'Support']);
    }

    public static function canCreate(): bool
    {
        return auth()->user() && in_array(auth()->user()->role, ['Super Admin', 'Moderator']);
    }

    public static function canEdit($record): bool
    {
        return auth()->user() && in_array(auth()->user()->role, ['Super Admin', 'Moderator']);
    }

    public static function canDelete($record): bool
    {
        return auth()->user() && auth()->user()->role === 'Super Admin';
    }
}
