<?php

namespace App\Filament\Resources\Quotations\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuotationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('quotation_number')
                    ->label('Quotation Number'),
                // TextColumn::make('client.name')
                //     ->label('Client Name'),
                TextColumn::make('quotation_date')
                    ->label('Quotation Date'),
                TextColumn::make('valid_until')
                    ->label('Valid Until'),
                // TextColumn::make('total_amount')
                //     ->label('Total Amount'),
                // TextColumn::make('discount')
                //     ->label('Discount'),
                // TextColumn::make('tax')
                //     ->label('Tax'),
                TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->prefix('Rp. ')
                    ->formatStateUsing(fn($state) => number_format((float) $state, 0, ',', '.')),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->modalHeading('View Quotation')
                        ->modalFooterActions([
                            Action::make('generate_file')
                                ->label('Generate File')
                                ->icon('heroicon-o-document-arrow-down')
                                ->color('primary')
                                ->action(function ($record) {
                                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.quotation', [
                                        'quotation' => $record,
                                    ]);

                                    return response()->streamDownload(
                                        fn() => print($pdf->output()),
                                        'quotation-' . $record->id . '.pdf'
                                    );
                                }),
                            Action::make('close')
                                ->label('Close')
                                ->color('gray')
                                ->close(),
                        ]),
                    EditAction::make()
                        ->modal()
                        ->modalHeading('Edit Quotation')
                        ->modalSubmitActionLabel('Save')
                        ->visible(fn($record) => $record->status == 'draft' or $record->status == 'rejected'),
                    Action::make('sent')
                        ->label('Sent to Client')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('success')
                        ->visible(fn($record) => $record->status == 'draft' or $record->status == 'rejected')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'sent',
                            ]);
                        }),
                    Action::make('approve')
                        ->label('Approve')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->visible(fn($record) => $record->status == 'sent')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'approved',
                            ]);
                            if ($record->project) {
                                $record->project->update([
                                    'status' => 'Quotation Approved',
                                ]);
                            }
                        }),
                    Action::make('reject')
                        ->label('Reject')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn($record) => $record->status == 'sent')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'rejected',
                            ]);
                            if ($record->project) {
                                $record->project->update([
                                    'status' => 'Qouotation Rejected',
                                ]);
                            }
                        }),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
