<?php

namespace App\Filament\Resources\Reports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Report;

class ReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('reporter.email')
                    ->label('Reporter Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reporter.first_name')
                    ->label('Reporter Name')
                    ->searchable(),
                TextColumn::make('reported.email')
                    ->label('Reported Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reported.first_name')
                    ->label('Reported Name')
                    ->searchable(),
                TextColumn::make('reason')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Resolved' => 'success',
                        'Pending' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Resolved' => 'Resolved',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    Action::make('resolve')
                        ->label('Resolve')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Report $record) => $record->update(['status' => 'Resolved']))
                        ->visible(fn (Report $record): bool => $record->status === 'Pending'),
                    Action::make('suspend_reported')
                        ->label('Suspend User')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Report $record) {
                            $record->update(['status' => 'Resolved']);
                            $record->reported->update(['is_active' => false]);
                        })
                        ->visible(fn (Report $record): bool => $record->status === 'Pending'),
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
