<?php

namespace App\Filament\Resources\PreRegisteredUsers\Pages;

use App\Filament\Resources\PreRegisteredUsers\PreRegisteredUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePreRegisteredUser extends CreateRecord
{
    protected static string $resource = PreRegisteredUserResource::class;
}
