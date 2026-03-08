<?php

namespace App\Filament\Resources\Productions\Pages;

use App\Filament\Resources\Productions\ProductionResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Project;

class CreateProduction extends CreateRecord
{
    protected static string $resource = ProductionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        if ($this->record && $this->record->project_id) {
            Project::where('id', $this->record->project_id)->update([
                'status' => 'in progress production',
            ]);
        }
    }
}
