<?php

namespace App\Filament\Resources\BlockedUsers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class BlockedUsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('Blocker Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.first_name')
                    ->label('Blocker Name')
                    ->searchable(),
                TextColumn::make('blockedUser.email')
                    ->label('Blocked User Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('blockedUser.first_name')
                    ->label('Blocked User Name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    DeleteAction::make()
                        ->label('Unblock'),
                ])
                ->label('Actions')
                ->icon('heroicon-m-chevron-down')
                ->iconPosition('after')
                ->color('primary')
                ->button(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
