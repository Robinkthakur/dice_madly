<?php

namespace App\Filament\Resources\UserMatches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class UserMatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('User One Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.first_name')
                    ->label('User One Name')
                    ->searchable(),
                TextColumn::make('matchedUser.email')
                    ->label('User Two Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('matchedUser.first_name')
                    ->label('User Two Name')
                    ->searchable(),
                TextColumn::make('match_percentage')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    DeleteAction::make(),
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
