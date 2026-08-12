<?php

namespace App\Filament\Resources\BlockedUsers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class BlockedUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Block Details')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'email')
                            ->searchable()
                            ->required()
                            ->label('Blocker User'),
                        Select::make('blocked_user_id')
                            ->relationship('blockedUser', 'email')
                            ->searchable()
                            ->required()
                            ->label('Blocked User'),
                    ]),
            ]);
    }
}
