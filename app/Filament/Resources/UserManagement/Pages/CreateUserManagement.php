<?php

namespace App\Filament\Resources\UserManagement\Pages;

use App\Filament\Resources\UserManagement\UserManagementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserManagement extends CreateRecord
{
    protected static string $resource = UserManagementResource::class;
}
