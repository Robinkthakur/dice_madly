<?php

namespace App\Filament\Resources\CompanionRentals\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class CompanionRentalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Companion Rental & Partner Registration')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('reference_no')
                                    ->label('Reference Code')
                                    ->disabled()
                                    ->placeholder('Auto-generated upon submission'),
                                Select::make('type')
                                    ->label('Registration Role / Type')
                                    ->options([
                                        'client' => 'Client (Looking to Rent Companion)',
                                        'partner' => 'Rental Partner (Offering Companion Service)',
                                    ])
                                    ->required(),
                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(100),
                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->maxLength(150),
                                TextInput::make('phone')
                                    ->label('Mobile / WhatsApp')
                                    ->tel()
                                    ->required()
                                    ->maxLength(25),
                                Select::make('gender')
                                    ->label('Gender')
                                    ->options([
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                        'Other' => 'Other',
                                    ])
                                    ->required(),
                                Select::make('rent_target')
                                    ->label('Companion Target / Offering')
                                    ->options([
                                        'boyfriend' => 'Boyfriend Companion',
                                        'girlfriend' => 'Girlfriend Companion',
                                        'both' => 'Both / Flexible',
                                    ])
                                    ->required(),
                                TextInput::make('age')
                                    ->label('Age')
                                    ->numeric()
                                    ->minValue(18)
                                    ->maxValue(99),
                                TextInput::make('city')
                                    ->label('City / Location')
                                    ->maxLength(100),
                                TextInput::make('duration_hours')
                                    ->label('Duration / Hours Requested or Available')
                                    ->placeholder('e.g. 2-4 Hours, Evening Dinner, Weekend'),
                                TextInput::make('budget_or_rate')
                                    ->label('Budget / Expected Rate')
                                    ->placeholder('e.g. ₹1,500/hr, Negotiable'),
                                Select::make('status')
                                    ->label('Application / Survey Status')
                                    ->options([
                                        'pending' => 'Pending Review',
                                        'contacted' => 'Contacted / In Discussion',
                                        'approved' => 'Approved / Verified',
                                        'rejected' => 'Rejected',
                                        'completed' => 'Completed',
                                    ])
                                    ->default('pending')
                                    ->required(),
                            ]),
                        Textarea::make('remarks')
                            ->label('Client Expectations / Partner Remarks')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('hobbies_interests')
                            ->label('Hobbies, Interests & Languages')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('partner_experience')
                            ->label('Partner Background / Experience / Notes')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('admin_notes')
                            ->label('Internal Admin Review Notes')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
