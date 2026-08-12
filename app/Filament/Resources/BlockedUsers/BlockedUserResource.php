<?php

namespace App\Filament\Resources\BlockedUsers;

use App\Filament\Resources\BlockedUsers\Pages\CreateBlockedUser;
use App\Filament\Resources\BlockedUsers\Pages\EditBlockedUser;
use App\Filament\Resources\BlockedUsers\Pages\ListBlockedUsers;
use App\Filament\Resources\BlockedUsers\Schemas\BlockedUserForm;
use App\Filament\Resources\BlockedUsers\Tables\BlockedUsersTable;
use App\Models\BlockedUser;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use App\Filament\Traits\HasRoleBasedAuthorization;

class BlockedUserResource extends Resource
{
    use HasRoleBasedAuthorization;

    protected static ?string $model = BlockedUser::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-no-symbol';

    protected static string|\UnitEnum|null $navigationGroup = 'User Management';

    public static function form(Schema $schema): Schema
    {
        return BlockedUserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BlockedUsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBlockedUsers::route('/'),
            'create' => CreateBlockedUser::route('/create'),
            'edit' => EditBlockedUser::route('/{record}/edit'),
        ];
    }
}
