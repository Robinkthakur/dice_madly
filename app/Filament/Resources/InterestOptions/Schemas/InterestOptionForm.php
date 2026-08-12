<?php

namespace App\Filament\Resources\InterestOptions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class InterestOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Interest Option details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Select::make('category')
                            ->options([
                                'Creativity' => 'Creativity',
                                'Sports & Fitness' => 'Sports & Fitness',
                                'Entertainment' => 'Entertainment',
                                'Food & Drink' => 'Food & Drink',
                                'Travel & Outdoors' => 'Travel & Outdoors',
                            ])
                            ->required(),
                    ]),
            ]);
    }
}
