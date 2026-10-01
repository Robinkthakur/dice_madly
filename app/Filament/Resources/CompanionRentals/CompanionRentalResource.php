<?php

namespace App\Filament\Resources\CompanionRentals;

use App\Filament\Resources\CompanionRentals\Pages\CreateCompanionRental;
use App\Filament\Resources\CompanionRentals\Pages\EditCompanionRental;
use App\Filament\Resources\CompanionRentals\Pages\ListCompanionRentals;
use App\Filament\Resources\CompanionRentals\Schemas\CompanionRentalForm;
use App\Filament\Resources\CompanionRentals\Tables\CompanionRentalsTable;
use App\Models\CompanionRental;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use App\Filament\Traits\HasRoleBasedAuthorization;

class CompanionRentalResource extends Resource
{
    use HasRoleBasedAuthorization;

    protected static ?string $model = CompanionRental::class;

    protected static ?string $modelLabel = 'Companion Rental Request';

    protected static ?string $pluralModelLabel = 'Rent BF / GF & Partners';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-heart';

    protected static string|\UnitEnum|null $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $pendingCount = static::getModel()::where('status', 'pending')->count();
        return $pendingCount > 0 ? (string) $pendingCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return CompanionRentalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompanionRentalsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompanionRentals::route('/'),
            'create' => CreateCompanionRental::route('/create'),
            'edit' => EditCompanionRental::route('/{record}/edit'),
        ];
    }
}
