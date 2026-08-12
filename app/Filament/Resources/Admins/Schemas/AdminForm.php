<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class AdminForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Section::make('Admin Details')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('email')
                                            ->email()
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255),
                                        TextInput::make('password')
                                            ->password()
                                            ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                                            ->dehydrated(fn ($state) => filled($state))
                                            ->required(fn (string $context): bool => $context === 'create')
                                            ->placeholder(fn (string $context): string => $context === 'create' ? 'Enter password' : 'Leave empty to keep existing'),
                                        Select::make('role')
                                            ->options([
                                                'Super Admin' => 'Super Admin',
                                                'Moderator' => 'Moderator',
                                                'Support' => 'Support',
                                            ])
                                            ->required()
                                            ->default('Super Admin'),
                                    ]),
                            ]),
                        Section::make('Avatar')
                            ->columnSpan(1)
                            ->schema([
                                FileUpload::make('profile_image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('admins')
                                    ->imageEditor(),
                            ]),
                    ]),
            ]);
    }
}
