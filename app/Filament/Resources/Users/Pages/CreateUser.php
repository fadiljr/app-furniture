<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
protected function afterCreate(): void
{
    $this->record->syncRoles($this->data['roles']);
}
}
