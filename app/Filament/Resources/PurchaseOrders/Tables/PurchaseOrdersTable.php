<?php

namespace App\Filament\Resources\PurchaseOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PurchaseOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('production.project.project_number')
                    ->label('Project Number')
                    ->searchable(),
                TextColumn::make('production.project.project_type')
                    ->label('Project Name')
                    ->searchable(),
                TextColumn::make('supplier.name')
                    ->label('Supplier Name')
                    ->searchable(),
                TextColumn::make('order_date')
                    ->label('Order Date')
                    ->date(),
                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->prefix('Rp.')
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                ->modal()
                ->modalHeading('Edit Purchase Order')
                ->modalSubmitActionLabel('Save Changes'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
