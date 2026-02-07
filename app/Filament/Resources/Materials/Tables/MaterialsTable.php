<?php

namespace App\Filament\Resources\Materials\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class MaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([

            TextColumn::make('name')->searchable(),

            TextColumn::make('unit'),

            TextColumn::make('stock')->badge(),

            TextColumn::make('price')->money('IDR'),

        ]);
    }
}