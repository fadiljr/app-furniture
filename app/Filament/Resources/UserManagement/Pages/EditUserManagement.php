<?php

namespace App\Filament\Resources\UserManagement\Pages;

use App\Filament\Resources\UserManagement\UserManagementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserManagement extends EditRecord
{
    protected static string $resource = UserManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
