<?php

namespace App\Filament\Resources\PreRegisteredUsers;

use App\Filament\Resources\PreRegisteredUsers\Pages\CreatePreRegisteredUser;
use App\Filament\Resources\PreRegisteredUsers\Pages\EditPreRegisteredUser;
use App\Filament\Resources\PreRegisteredUsers\Pages\ListPreRegisteredUsers;
use App\Filament\Resources\PreRegisteredUsers\Schemas\PreRegisteredUserForm;
use App\Filament\Resources\PreRegisteredUsers\Tables\PreRegisteredUsersTable;
use App\Models\PreRegisterUser;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use App\Filament\Traits\HasRoleBasedAuthorization;

class PreRegisteredUserResource extends Resource
{
    use HasRoleBasedAuthorization;

    protected static ?string $model = PreRegisterUser::class;

    protected static ?string $modelLabel = 'Pre-Registered User';

    protected static ?string $pluralModelLabel = 'Pre-Registered Users (Early Access)';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    protected static string|\UnitEnum|null $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PreRegisteredUserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PreRegisteredUsersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPreRegisteredUsers::route('/'),
            'create' => CreatePreRegisteredUser::route('/create'),
            'edit' => EditPreRegisteredUser::route('/{record}/edit'),
        ];
    }
}
