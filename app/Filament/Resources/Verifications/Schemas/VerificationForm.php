<?php

namespace App\Filament\Resources\Verifications\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;

class VerificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Verification Request Details')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'email')
                            ->searchable()
                            ->required()
                            ->label('User Account'),
                        Select::make('type')
                            ->options([
                                'Photo' => 'Photo',
                                'Email' => 'Email',
                                'Phone' => 'Phone',
                                'Government ID' => 'Government ID',
                            ])
                            ->required(),
                        TextInput::make('id_type')
                            ->label('ID / Document Type')
                            ->placeholder('e.g. Passport, Driver License')
                            ->nullable(),
                        FileUpload::make('document')
                            ->disk('public')
                            ->directory('verifications')
                            ->image()
                            ->nullable()
                            ->label('Uploaded Document / Selfie Photo'),
                        Select::make('status')
                            ->options([
                                'Pending' => 'Pending',
                                'Approved' => 'Approved',
                                'Rejected' => 'Rejected',
                            ])
                            ->required()
                            ->default('Pending'),
                    ]),
            ]);
    }
}
