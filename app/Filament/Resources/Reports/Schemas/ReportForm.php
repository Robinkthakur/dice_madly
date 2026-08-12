<?php

namespace App\Filament\Resources\Reports\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Report Safety Review Details')
                    ->schema([
                        Select::make('reported_by')
                            ->relationship('reporter', 'email')
                            ->searchable()
                            ->required()
                            ->label('Reporter User'),
                        Select::make('reported_user')
                            ->relationship('reported', 'email')
                            ->searchable()
                            ->required()
                            ->label('Reported User'),
                        Textarea::make('reason')
                            ->required()
                            ->rows(4),
                        Select::make('status')
                            ->options([
                                'Pending' => 'Pending',
                                'Resolved' => 'Resolved',
                            ])
                            ->required()
                            ->default('Pending'),
                    ]),
            ]);
    }
}
