<?php

namespace App\Filament\Resources\CompanionRentals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class CompanionRentalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('reference_no')
                    ->label('Ref Code')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('type')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'client' => 'info',
                        'partner' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'client' => 'Renting Client',
                        'partner' => 'Rental Partner',
                        default => ucfirst($state),
                    }),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Mobile')
                    ->searchable(),
                TextColumn::make('gender'),
                TextColumn::make('rent_target')
                    ->label('Target / Service')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'boyfriend' => 'warning',
                        'girlfriend' => 'danger',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'boyfriend' => 'Boyfriend',
                        'girlfriend' => 'Girlfriend',
                        default => 'Both / Flexible',
                    }),
                TextColumn::make('city')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('budget_or_rate')
                    ->label('Budget / Rate')
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'contacted' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'completed' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'client' => 'Renting Client',
                        'partner' => 'Rental Partner',
                    ]),
                SelectFilter::make('rent_target')
                    ->options([
                        'boyfriend' => 'Boyfriend',
                        'girlfriend' => 'Girlfriend',
                        'both' => 'Both / Flexible',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'contacted' => 'Contacted',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                    ]),
                SelectFilter::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Other' => 'Other',
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
