<?php

namespace App\Filament\Resources\PreRegisteredUsers\Pages;

use App\Filament\Resources\PreRegisteredUsers\PreRegisteredUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPreRegisteredUser extends EditRecord
{
    protected static string $resource = PreRegisteredUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
