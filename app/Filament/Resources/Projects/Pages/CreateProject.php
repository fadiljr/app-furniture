<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Quotation;
use Illuminate\Support\Facades\DB;


class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Successfully created project';
    }

    protected function afterCreate(): void
    {
        DB::transaction(function () {
            Quotation::create([
                'project_id' => $this->record->id,
                'quotation_number' => fn() => \App\Models\Quotation::generateQuotationNumber(),
                'quotation_date' => now(),
                'total_amount' => 0,
                'grand_total' => 0,
                'discount' => 0,
                'tax' => 0,
                'status' => 'draft',
            ]);
        });
    }
}
