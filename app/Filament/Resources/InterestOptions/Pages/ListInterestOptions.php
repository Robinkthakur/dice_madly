<?php

namespace App\Filament\Resources\InterestOptions\Pages;

use App\Filament\Resources\InterestOptions\InterestOptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInterestOptions extends ListRecords
{
    protected static string $resource = InterestOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
