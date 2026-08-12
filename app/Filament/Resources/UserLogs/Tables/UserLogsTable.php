<?php

namespace App\Filament\Resources\UserLogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class UserLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('User / Admin')
                    ->searchable()
                    ->sortable()
                    ->default(fn ($record) => isset($record->meta['admin_email']) ? 'Admin: ' . $record->meta['admin_email'] : 'Guest/System'),
                TextColumn::make('action')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'login' => 'success',
                        'logout' => 'warning',
                        'delete' => 'danger',
                        default => 'primary',
                    }),
                TextColumn::make('module')
                    ->searchable(),
                TextColumn::make('description')
                    ->limit(40)
                    ->searchable(),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable(),
                TextColumn::make('device_type')
                    ->label('Device'),
                TextColumn::make('platform')
                    ->label('OS'),
                TextColumn::make('browser'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('action')
                    ->options([
                        'login' => 'Login',
                        'logout' => 'Logout',
                        'create' => 'Create',
                        'update' => 'Update',
                        'delete' => 'Delete',
                    ]),
                SelectFilter::make('module')
                    ->options([
                        'auth' => 'Auth',
                        'profile' => 'Profile',
                        'matches' => 'Matches',
                        'chat' => 'Chat',
                        'payment' => 'Payment',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
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
