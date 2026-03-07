<?php

namespace App\Filament\Resources\Invoices\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('project.project_number')
                    ->label('Project Number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('project.project_type')
                    ->label('Project Name'),
                TextColumn::make('project.client.name')
                    ->label('Client Name')
                    ->searchable(),
                TextColumn::make('invoice_number')
                    ->label('Invoice Number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('invoice_date')
                    ->label('Invoice Date')
                    ->sortable()
                    ->dateTime('d M Y'),
                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('IDR', true),
                TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->money('IDR', true),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
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
