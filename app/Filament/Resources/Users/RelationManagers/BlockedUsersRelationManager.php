<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class BlockedUsersRelationManager extends RelationManager
{
    protected static string $relationship = 'blockedUsers';

    protected static ?string $title = 'Blocked Users';

    public function form(Schema $schema): Schema
    {
        return $schema;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('blockedUser.email')
                    ->label('Blocked User Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('blockedUser.first_name')
                    ->label('Blocked User Name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Blocked At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->headerActions([])
            ->actions([
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
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
