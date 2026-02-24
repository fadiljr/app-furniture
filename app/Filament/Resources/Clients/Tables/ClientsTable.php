<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use filament\Actions\Action;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([

            TextColumn::make('client_code')
                ->label('Client Code')
                ->searchable(),

            TextColumn::make('name')->searchable(),

            TextColumn::make('company.name')
                ->label('Company')
                ->searchable()
                ->sortable(),

            TextColumn::make('phone'),

            TextColumn::make('address')->limit(30),
        ])
        ->actions([
            //
            EditAction::make(),
            DeleteAction::make(),
        ]);
    }
}