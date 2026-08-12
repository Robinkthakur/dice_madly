<?php

namespace App\Filament\Resources\UserMatches;

use App\Filament\Resources\UserMatches\Pages\CreateUserMatch;
use App\Filament\Resources\UserMatches\Pages\EditUserMatch;
use App\Filament\Resources\UserMatches\Pages\ListUserMatches;
use App\Filament\Resources\UserMatches\Schemas\UserMatchForm;
use App\Filament\Resources\UserMatches\Tables\UserMatchesTable;
use App\Models\UserMatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use App\Filament\Traits\HasRoleBasedAuthorization;

class UserMatchResource extends Resource
{
    use HasRoleBasedAuthorization;

    protected static ?string $model = UserMatch::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-heart';

    protected static string|\UnitEnum|null $navigationGroup = 'Matchmaking';

    public static function form(Schema $schema): Schema
    {
        return UserMatchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserMatchesTable::configure($table);
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
            'index' => ListUserMatches::route('/'),
            'create' => CreateUserMatch::route('/create'),
            'edit' => EditUserMatch::route('/{record}/edit'),
        ];
    }
}
