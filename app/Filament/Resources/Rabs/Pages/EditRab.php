<?php

namespace App\Filament\Resources\Rabs\Pages;

use App\Filament\Resources\Rabs\RabResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;

class EditRab extends EditRecord
{
    protected static string $resource = RabResource::class;

    protected function getHeaderActions(): array
    {
    return [

        Action::make('download_pdf')
            ->label('Download PDF')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->action(function () {

                $rab = $this->record->load('items', 'project');

                $pdf = Pdf::loadView('pdf.rab', [
                    'rab' => $rab,
                ])->setPaper('a4');

                return response()->streamDownload(
                    fn () => print($pdf->output()),
                    'RAB-' . $rab->nomor_rab . '.pdf'
                );
            }),

        DeleteAction::make(),
    ];
}

}
