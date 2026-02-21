<?php

namespace App\Filament\Resources\Quotations\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                TextColumn::make('client_name')
                    ->label('Client Name'),
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
                    ->label('Grand Total'),
                TextColumn::make('status')
                    ->label('Status'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
