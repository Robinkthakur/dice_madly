<?php

namespace App\Filament\Resources\CompanionRentals\Pages;

use App\Filament\Resources\CompanionRentals\CompanionRentalResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCompanionRental extends CreateRecord
{
    protected static string $resource = CompanionRentalResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['reference_no'])) {
            $prefix = ($data['type'] ?? 'client') === 'partner' ? 'DM-PTR-' : 'DM-RNT-';
            $data['reference_no'] = $prefix . strtoupper(Str::random(6));
        }

        return $data;
    }
}
