<?php

namespace App\Filament\Resources\UserMatches\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class UserMatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Match Details')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'email')
                            ->searchable()
                            ->required()
                            ->label('First User'),
                        Select::make('matched_user_id')
                            ->relationship('matchedUser', 'email')
                            ->searchable()
                            ->required()
                            ->label('Second User'),
                        TextInput::make('match_percentage')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                    ]),
            ]);
    }
}
