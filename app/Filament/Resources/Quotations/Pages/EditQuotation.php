<?php

namespace App\Filament\Resources\Quotations\Pages;

use App\Filament\Resources\Quotations\QuotationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    protected function getFormActions(): array
    {
        return [
            ...parent::getFormActions(),

            Action::make('generatePdf')
                ->label('Generate PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function ($record) {
                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.quotation', [
                        'quotation' => $record,
                    ]);

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'quotation-' . $record->id . '.pdf'
                    );
                }),

            DeleteAction::make()
                ->label('Delete')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->delete();
                    $this->redirect($this->getResource()::getUrl('index'));
                }),
        ];
    }
}
