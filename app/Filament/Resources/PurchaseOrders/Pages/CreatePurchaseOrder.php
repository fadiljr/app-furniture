<?php

namespace App\Filament\Resources\PurchaseOrders\Pages;

use App\Filament\Resources\PurchaseOrders\PurchaseOrderResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Production;

class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function afterCreate(): void
    {
        // You can add any additional logic here after creating a purchase order
        if ($this->record && $this->record->project_id) {
            Production::where('id', $this->record->production_id)->update([
                'status' => 'in progress purchase order',
            ]);
        }
    }
}
