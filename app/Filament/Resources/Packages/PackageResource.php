<?php

namespace App\Filament\Resources\Packages;

use App\Filament\Resources\Packages\Pages\CreatePackage;
use App\Filament\Resources\Packages\Pages\EditPackage;
use App\Filament\Resources\Packages\Pages\ListPackages;
use App\Filament\Resources\Packages\Schemas\PackageForm;
use App\Filament\Resources\Packages\Tables\PackagesTable;
use App\Models\Package;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    protected static string|\UnitEnum|null $navigationGroup = 'Payments & Plans';

    protected static function getAuthenticatedAdmin()
    {
        return auth('admin')->user() ?? auth()->user();
    }

    public static function canViewAny(): bool
    {
        $user = static::getAuthenticatedAdmin();
        return $user && in_array($user->role, ['Super Admin', 'Moderator']);
    }

    public static function canCreate(): bool
    {
        $user = static::getAuthenticatedAdmin();
        return $user && $user->role === 'Super Admin';
    }

    public static function canEdit($record): bool
    {
        $user = static::getAuthenticatedAdmin();
        return $user && $user->role === 'Super Admin';
    }

    public static function canDelete($record): bool
    {
        $user = static::getAuthenticatedAdmin();
        return $user && $user->role === 'Super Admin';
    }

    public static function form(Schema $schema): Schema
    {
        return PackageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PackagesTable::configure($table);
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
            'index' => ListPackages::route('/'),
            'create' => CreatePackage::route('/create'),
            'edit' => EditPackage::route('/{record}/edit'),
        ];
    }
}
