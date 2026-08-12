<?php

namespace App\Filament\Resources\InterestOptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class InterestOptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Creativity' => 'info',
                        'Sports & Fitness' => 'success',
                        'Entertainment' => 'warning',
                        'Food & Drink' => 'danger',
                        'Travel & Outdoors' => 'gray',
                        default => 'primary',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'Creativity' => 'Creativity',
                        'Sports & Fitness' => 'Sports & Fitness',
                        'Entertainment' => 'Entertainment',
                        'Food & Drink' => 'Food & Drink',
                        'Travel & Outdoors' => 'Travel & Outdoors',
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
