<?php

namespace App\Filament\Resources\Rabs\Pages;

use App\Filament\Resources\Rabs\RabResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRab extends CreateRecord
{
    protected static string $resource = RabResource::class;

protected function afterCreate(): void
    {
        $this->hitungUlangTotal();
    }

    protected function hitungUlangTotal(): void
    {
        $rab = $this->record->load('items');

        $subtotal = $rab->items->sum(function ($item) {
            return ($item->volume ?? 0) * ($item->harga_satuan ?? 0);
        });

        $diskon = $rab->diskon ?? 0;
        $pajakPersen = $rab->pajak ?? 0;

        $dpp = max($subtotal - $diskon, 0);
        $pajakNominal = $dpp * ($pajakPersen / 100);

        $rab->update([
            'subtotal' => $subtotal,
            'grand_total' => $dpp + $pajakNominal,
        ]);
    }

}
