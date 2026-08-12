<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                ImageColumn::make('profile_image')
                    ->circular()
                    ->disk('public')
                    ->label('Avatar')
                    ->defaultImageUrl(url('/images/default-avatar.svg')),
                TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('last_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('gender'),
                TextColumn::make('age')
                    ->numeric(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                IconColumn::make('is_verified')
                    ->boolean()
                    ->label('Verified'),
                IconColumn::make('is_admin')
                    ->boolean()
                    ->label('Admin'),
                TextColumn::make('onboarding_step')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'bio_dp' => 'warning',
                        'id_proof' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                Filter::make('is_active')
                    ->label('Active Only')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
                Filter::make('is_verified')
                    ->label('Verified Only')
                    ->query(fn (Builder $query): Builder => $query->where('is_verified', true)),
                Filter::make('is_admin')
                    ->label('Admins Only')
                    ->query(fn (Builder $query): Builder => $query->where('is_admin', true)),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    Action::make('suspend')
                        ->label('Suspend')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn (User $record) => $record->update(['is_active' => false]))
                        ->visible(fn (User $record): bool => (bool) $record->is_active),
                    Action::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (User $record) => $record->update(['is_active' => true]))
                        ->visible(fn (User $record): bool => !(bool) $record->is_active),
                    Action::make('verify')
                        ->label('Verify')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (User $record) => $record->update([
                            'is_verified' => true,
                            'verified_until' => now()->addYear(),
                        ]))
                        ->visible(fn (User $record): bool => !(bool) $record->is_verified),
                    Action::make('send_notification')
                        ->label('Send Notification')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('info')
                        ->form([
                            \Filament\Forms\Components\TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            \Filament\Forms\Components\Textarea::make('message')
                                ->required(),
                            \Filament\Forms\Components\Select::make('type')
                                ->options([
                                    'broadcast' => 'Broadcast / System Announcement',
                                    'like' => 'Profile Like Alert',
                                    'match' => 'Match Alert',
                                    'connect' => 'Connection Request Alert',
                                    'premium' => 'Premium Alert',
                                ])
                                ->default('broadcast')
                                ->required(),
                        ])
                        ->action(function (User $record, array $data): void {
                            \App\Models\Notification::create([
                                'user_id' => $record->id,
                                'title' => $data['title'],
                                'message' => $data['message'],
                                'type' => $data['type'],
                            ]);

                            \Filament\Notifications\Notification::make()
                                ->title('Notification Sent')
                                ->body("Notification sent to {$record->first_name} successfully.")
                                ->success()
                                ->send();
                        }),
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
                    \Filament\Actions\BulkAction::make('broadcast_notification')
                        ->label('Broadcast Notification')
                        ->icon('heroicon-o-megaphone')
                        ->color('primary')
                        ->form([
                            \Filament\Forms\Components\TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            \Filament\Forms\Components\Textarea::make('message')
                                ->required(),
                            \Filament\Forms\Components\Select::make('type')
                                ->options([
                                    'broadcast' => 'Broadcast / System Announcement',
                                    'like' => 'Profile Like Alert',
                                    'match' => 'Match Alert',
                                    'connect' => 'Connection Request Alert',
                                    'premium' => 'Premium Alert',
                                ])
                                ->default('broadcast')
                                ->required(),
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data): void {
                            foreach ($records as $user) {
                                \App\Models\Notification::create([
                                    'user_id' => $user->id,
                                    'title' => $data['title'],
                                    'message' => $data['message'],
                                    'type' => $data['type'],
                                ]);
                            }

                            \Filament\Notifications\Notification::make()
                                ->title('Broadcast Sent')
                                ->body("Custom broadcast notification sent to {$records->count()} users successfully.")
                                ->success()
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
