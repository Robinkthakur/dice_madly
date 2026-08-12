<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\KeyValue;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Section::make('Transaction Info')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('user.email')
                                    ->label('User Account')
                                    ->disabled(),
                                TextInput::make('package.name')
                                    ->label('Package Plan')
                                    ->disabled(),
                                TextInput::make('transaction_id')
                                    ->label('Transaction / Order ID')
                                    ->disabled(),
                                TextInput::make('amount')
                                    ->prefix('$')
                                    ->disabled(),
                            ]),

                        Section::make('Gateway details')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('gateway')
                                    ->disabled(),
                                TextInput::make('status')
                                    ->disabled(),
                                TextInput::make('created_at')
                                    ->label('Payment Date')
                                    ->disabled(),
                            ]),
                    ]),

                Section::make('Gateway Response Data')
                    ->schema([
                        KeyValue::make('gateway_response')
                            ->label('API Payload Response')
                            ->disabled(),
                    ])
                    ->collapsible(),
            ]);
    }
}
