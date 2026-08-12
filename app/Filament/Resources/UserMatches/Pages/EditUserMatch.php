<?php

namespace App\Filament\Resources\UserMatches\Pages;

use App\Filament\Resources\UserMatches\UserMatchResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserMatch extends EditRecord
{
    protected static string $resource = UserMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
