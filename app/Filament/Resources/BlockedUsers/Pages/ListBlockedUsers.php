<?php

namespace App\Filament\Resources\BlockedUsers\Pages;

use App\Filament\Resources\BlockedUsers\BlockedUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBlockedUsers extends ListRecords
{
    protected static string $resource = BlockedUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
