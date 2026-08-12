<?php

namespace App\Filament\Resources\UserLogs\Pages;

use App\Filament\Resources\UserLogs\UserLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserLog extends EditRecord
{
    protected static string $resource = UserLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
