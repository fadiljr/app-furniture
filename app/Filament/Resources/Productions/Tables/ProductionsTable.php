<?php

namespace App\Filament\Resources\Productions\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('project.project_number')
                ->label('Project Number')
                ->searchable()
                ->sortable(),
                TextColumn::make('project.project_type')
                ->label('Project Name')
                ->searchable()
                ->sortable(),
                TextColumn::make('project.client.name')
                ->label('Client Name')
                ->searchable()
                ->sortable(),
                TextColumn::make('status')
                ->label('Status')
                ->searchable()
                ->sortable(),
                TextColumn::make('progress')
                ->label('Progress')
                ->formatStateUsing(fn($state) => $state . '%')
                ->searchable()
                ->sortable(),
                TextColumn::make('start_date')
                ->label('Start Date')
                ->date()
                ->searchable()
                ->sortable(),
                TextColumn::make('end_date')
                ->label('End Date')
                ->date()
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->modal()
                        ->modalHeading('Edit Production')
                        ->modalSubmitActionLabel('Save'),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
