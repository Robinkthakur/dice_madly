<?php

namespace App\Filament\Resources\CompanionRentals\Pages;

use App\Filament\Resources\CompanionRentals\CompanionRentalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanionRentals extends ListRecords
{
    protected static string $resource = CompanionRentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
