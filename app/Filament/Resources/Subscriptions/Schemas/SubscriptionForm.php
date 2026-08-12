<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Section::make('Subscription details')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('user.email')
                                    ->label('User Account')
                                    ->disabled(),
                                TextInput::make('package.name')
                                    ->label('Package Plan')
                                    ->disabled(),
                                TextInput::make('status')
                                    ->disabled(),
                            ]),

                        Section::make('Subscription Timeline')
                            ->columnSpan(1)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->disabled(),
                                DatePicker::make('end_date')
                                    ->disabled(),
                                TextInput::make('created_at')
                                    ->label('Created Timestamp')
                                    ->disabled(),
                            ]),
                    ]),
            ]);
    }
}
