<?php

namespace App\Filament\Resources\BlockedUsers\Pages;

use App\Filament\Resources\BlockedUsers\BlockedUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBlockedUser extends EditRecord
{
    protected static string $resource = BlockedUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
