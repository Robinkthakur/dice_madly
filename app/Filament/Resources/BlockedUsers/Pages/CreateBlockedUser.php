<?php

namespace App\Filament\Resources\BlockedUsers\Pages;

use App\Filament\Resources\BlockedUsers\BlockedUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlockedUser extends CreateRecord
{
    protected static string $resource = BlockedUserResource::class;
}
