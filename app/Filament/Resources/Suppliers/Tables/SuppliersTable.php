<?php

namespace App\Filament\Resources\Suppliers\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class SuppliersTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([

            TextColumn::make('name')->searchable(),

            TextColumn::make('phone'),

            TextColumn::make('address')->limit(30),

        ]);
    }
}