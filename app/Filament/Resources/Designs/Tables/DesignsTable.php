<?php

namespace App\Filament\Resources\Designs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ViewColumn;

class DesignsTable
{
        public static function configure(Table $table): Table
{
        return $table
        ->columns([
            TextColumn::make('design_id')
                ->label('Design ID')
                ->searchable()
                ->sortable(),

            TextColumn::make('description')
                ->limit(40)
                ->tooltip(fn ($record) => $record->description),

            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            //
        ])
        ->recordActions([
    Action::make('preview')
        ->label('Preview')
        ->icon('heroicon-o-eye')
        ->modalHeading('Preview Design Files')
        ->modalSubmitAction(false)
        ->modalCancelActionLabel('Tutup')
        ->modalWidth('5xl')
        ->modalContent(fn ($record) => view(
            'filament.designs.preview-modal',
            ['files' => $record->file_path]
        )),

    EditAction::make(),
]);
           
}
}
