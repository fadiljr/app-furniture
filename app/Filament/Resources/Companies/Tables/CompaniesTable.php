<?php

namespace App\Filament\Resources\Companies\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class CompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Company Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('company_code')
                    ->label('Company Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('address')
                    ->label('Address')
                    ->limit(40),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])

            ->filters([
                //
            ])

            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
