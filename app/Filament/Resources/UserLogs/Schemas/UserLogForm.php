<?php

namespace App\Filament\Resources\UserLogs\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class UserLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Section::make('Activity Details')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('user.email')
                                    ->label('User Account')
                                    ->disabled(),
                                TextInput::make('action')
                                    ->disabled(),
                                TextInput::make('module')
                                    ->disabled(),
                                TextInput::make('ip_address')
                                    ->label('IP Address')
                                    ->disabled(),
                                TextInput::make('created_at')
                                    ->label('Log Timestamp')
                                    ->disabled(),
                                Textarea::make('description')
                                    ->disabled()
                                    ->rows(3),
                            ]),

                        Section::make('System & Device Info')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('device_type')
                                    ->disabled(),
                                TextInput::make('platform')
                                    ->label('Operating System')
                                    ->disabled(),
                                TextInput::make('browser')
                                    ->disabled(),
                                Textarea::make('user_agent')
                                    ->disabled()
                                    ->rows(3),
                            ]),
                    ]),

                Section::make('Values & Metadata')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                KeyValue::make('old_values')
                                    ->label('Old Values')
                                    ->disabled(),
                                KeyValue::make('new_values')
                                    ->label('New Values')
                                    ->disabled(),
                                KeyValue::make('meta')
                                    ->label('Meta JSON')
                                    ->disabled(),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }
}
