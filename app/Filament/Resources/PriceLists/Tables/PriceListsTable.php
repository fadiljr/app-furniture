<?php

namespace App\Filament\Resources\PriceLists\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PriceListsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('item_name')
                    ->label('Item Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Price')
                    ->sortable()
                    ->money('IDR', true),
                TextColumn::make('unit')    
                    ->label('Unit')
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),
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
