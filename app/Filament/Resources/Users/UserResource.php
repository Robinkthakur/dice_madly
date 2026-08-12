<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Filament\Traits\HasRoleBasedAuthorization;
use App\Filament\Resources\Users\RelationManagers\MatchesRelationManager;
use App\Filament\Resources\Users\RelationManagers\ProfileVisitsRelationManager;
use App\Filament\Resources\Users\RelationManagers\VisitsMadeRelationManager;
use App\Filament\Resources\Users\RelationManagers\SubscriptionsRelationManager;
use App\Filament\Resources\Users\RelationManagers\PaymentsRelationManager;
use App\Filament\Resources\Users\RelationManagers\BlockedUsersRelationManager;
use App\Filament\Resources\Users\RelationManagers\UserLogsRelationManager;
use App\Filament\Resources\Users\RelationManagers\VerificationsRelationManager;

class UserResource extends Resource
{
    use HasRoleBasedAuthorization;

    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = 'User Management';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MatchesRelationManager::class,
            ProfileVisitsRelationManager::class,
            VisitsMadeRelationManager::class,
            SubscriptionsRelationManager::class,
            PaymentsRelationManager::class,
            BlockedUsersRelationManager::class,
            UserLogsRelationManager::class,
            VerificationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
