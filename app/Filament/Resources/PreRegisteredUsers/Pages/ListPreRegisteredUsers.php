<?php

namespace App\Filament\Resources\PreRegisteredUsers\Pages;

use App\Filament\Resources\PreRegisteredUsers\PreRegisteredUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPreRegisteredUsers extends ListRecords
{
    protected static string $resource = PreRegisteredUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
