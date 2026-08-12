<?php

namespace App\Filament\Resources\Packages\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Package Info')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                TextInput::make('price')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required(),
                                TextInput::make('duration_days')
                                    ->label('Duration (Days)')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('contact_limit')
                                    ->label('Contact Limit')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('interest_limit')
                                    ->label('Interest Limit')
                                    ->numeric()
                                    ->required(),
                            ]),
                    ]),

                Section::make('Permissions & Access')
                    ->schema([
                        Toggle::make('chat_access')
                            ->label('Has Chat Access')
                            ->default(true),
                        Toggle::make('view_contact')
                            ->label('Can View Contact Info')
                            ->default(true),
                    ]),
            ]);
    }
}
