<?php

namespace App\Filament\Resources\UserLogs\Pages;

use App\Filament\Resources\UserLogs\UserLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserLog extends CreateRecord
{
    protected static string $resource = UserLogResource::class;
}
