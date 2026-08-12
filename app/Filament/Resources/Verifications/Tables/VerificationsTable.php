<?php

namespace App\Filament\Resources\Verifications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Verification;

class VerificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('User Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.first_name')
                    ->label('First Name')
                    ->searchable(),
                TextColumn::make('user.last_name')
                    ->label('Last Name')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Government ID' => 'warning',
                        'Photo' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('id_type')
                    ->label('ID Type'),
                ImageColumn::make('document')
                    ->disk('public')
                    ->label('Doc Preview')
                    ->width(100)
                    ->height(100)
                    ->square()
                    ->openUrlInNewTab(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Approved' => 'success',
                        'Pending' => 'warning',
                        'Rejected' => 'danger',
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
                        'Approved' => 'Approved',
                        'Rejected' => 'Rejected',
                    ]),
                SelectFilter::make('type')
                    ->options([
                        'Photo' => 'Photo',
                        'Email' => 'Email',
                        'Phone' => 'Phone',
                        'Government ID' => 'Government ID',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    Action::make('approve')
                        ->label('Approve')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Verification $record) {
                            $record->update(['status' => 'Approved']);
                            // Set the user as verified as well
                            $record->user->update([
                                'is_verified' => true,
                                'verified_until' => now()->addYear(),
                            ]);
                        })
                        ->visible(fn (Verification $record): bool => $record->status === 'Pending'),
                    Action::make('reject')
                        ->label('Reject')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Verification $record) {
                            $record->update(['status' => 'Rejected']);
                        })
                        ->visible(fn (Verification $record): bool => $record->status === 'Pending'),
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
