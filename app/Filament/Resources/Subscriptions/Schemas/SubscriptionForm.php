<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
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
                        Section::make('Subscription Details')
                            ->columnSpan(1)
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'email')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('User Account'),
                                Select::make('package_id')
                                    ->relationship('package', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('Package Plan'),
                                Select::make('status')
                                    ->options([
                                        'Active' => 'Active',
                                        'Expired' => 'Expired',
                                        'Cancelled' => 'Cancelled',
                                    ])
                                    ->default('Active')
                                    ->required(),
                            ]),

                        Section::make('Subscription Timeline')
                            ->columnSpan(1)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label('Start Date')
                                    ->default(now())
                                    ->required(),
                                DatePicker::make('end_date')
                                    ->label('End Date')
                                    ->default(now()->addDays(30))
                                    ->required(),
                                DateTimePicker::make('created_at')
                                    ->label('Created Timestamp')
                                    ->disabled()
                                    ->hiddenOn('create'),
                            ]),
                    ]),
            ]);
    }
}
