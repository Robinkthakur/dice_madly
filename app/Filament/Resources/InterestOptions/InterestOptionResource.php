<?php

namespace App\Filament\Resources\InterestOptions;

use App\Filament\Resources\InterestOptions\Pages\CreateInterestOption;
use App\Filament\Resources\InterestOptions\Pages\EditInterestOption;
use App\Filament\Resources\InterestOptions\Pages\ListInterestOptions;
use App\Filament\Resources\InterestOptions\Schemas\InterestOptionForm;
use App\Filament\Resources\InterestOptions\Tables\InterestOptionsTable;
use App\Models\InterestOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use App\Filament\Traits\HasRoleBasedAuthorization;

class InterestOptionResource extends Resource
{
    use HasRoleBasedAuthorization;

    protected static ?string $model = InterestOption::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static string|\UnitEnum|null $navigationGroup = 'Matchmaking';

    public static function form(Schema $schema): Schema
    {
        return InterestOptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InterestOptionsTable::configure($table);
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
            'index' => ListInterestOptions::route('/'),
            'create' => CreateInterestOption::route('/create'),
            'edit' => EditInterestOption::route('/{record}/edit'),
        ];
    }
}
