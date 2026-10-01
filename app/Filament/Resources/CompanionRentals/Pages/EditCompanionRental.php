<?php

namespace App\Filament\Resources\CompanionRentals\Pages;

use App\Filament\Resources\CompanionRentals\CompanionRentalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCompanionRental extends EditRecord
{
    protected static string $resource = CompanionRentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
