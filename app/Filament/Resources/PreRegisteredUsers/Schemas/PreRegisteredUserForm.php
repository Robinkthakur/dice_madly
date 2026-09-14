<?php

namespace App\Filament\Resources\PreRegisteredUsers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class PreRegisteredUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pre-Registration Profile')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('vip_ticket')
                                    ->label('VIP Ticket Code')
                                    ->disabled()
                                    ->placeholder('Auto-generated upon registration'),
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(100),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(150),
                                TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(25),
                                Select::make('gender')
                                    ->options([
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                        'Other' => 'Other',
                                    ]),
                                TextInput::make('age')
                                    ->numeric()
                                    ->minValue(18)
                                    ->maxValue(99),
                                TextInput::make('city')
                                    ->maxLength(100),
                                Select::make('interested_in')
                                    ->options([
                                        'dating' => 'Dating & Romance',
                                        'matrimony' => 'Serious Matrimony',
                                        'both' => 'Both Dating & Matrimony',
                                    ])
                                    ->default('both'),
                                Select::make('preferred_platform')
                                    ->options([
                                        'android' => 'Android (Google Play)',
                                        'ios' => 'iOS (Apple App Store)',
                                        'both' => 'Both Platforms',
                                    ])
                                    ->default('android')
                                    ->required(),
                                Select::make('status')
                                    ->options([
                                        'pending' => 'Pending Launch',
                                        'invited' => 'Invite Sent',
                                        'registered' => 'Fully Registered in App',
                                    ])
                                    ->default('pending')
                                    ->required(),
                            ]),
                        Textarea::make('notes')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
