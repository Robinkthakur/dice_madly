<?php

namespace App\Filament\Resources\InterestOptions\Pages;

use App\Filament\Resources\InterestOptions\InterestOptionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInterestOption extends EditRecord
{
    protected static string $resource = InterestOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
