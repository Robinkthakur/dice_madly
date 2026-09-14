<?php

namespace App\Filament\Resources\PreRegisteredUsers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class PreRegisteredUsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('vip_ticket')
                    ->label('VIP Ticket')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('preferred_platform')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'android' => 'success',
                        'ios' => 'info',
                        'both' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => strtoupper($state)),
                TextColumn::make('gender')
                    ->placeholder('—'),
                TextColumn::make('age')
                    ->numeric()
                    ->placeholder('—'),
                TextColumn::make('city')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('interested_in')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'dating' => 'danger',
                        'matrimony' => 'primary',
                        'both' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'invited' => 'info',
                        'registered' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Registered At')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('preferred_platform')
                    ->options([
                        'android' => 'Android',
                        'ios' => 'iOS',
                        'both' => 'Both',
                    ]),
                SelectFilter::make('interested_in')
                    ->options([
                        'dating' => 'Dating',
                        'matrimony' => 'Matrimony',
                        'both' => 'Both',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'invited' => 'Invited',
                        'registered' => 'Registered',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
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
