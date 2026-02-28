<?php

namespace App\Filament\Resources\Designs\Pages;

use App\Filament\Resources\Designs\DesignResource;
use Filament\Resources\Pages\CreateRecord;
use Carbon\Carbon;

class CreateDesign extends CreateRecord
{
    protected static string $resource = DesignResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['design_id'] = 'DSN-' . now()->format('YmdHis');


    return $data;
}
 protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}


}
