<?php

namespace App\Filament\Resources\Surveys\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SurveysTable
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
                TextColumn::make('survey_date')
                    ->label('Survey Date')
                    ->sortable()
                    ->dateTime('d M Y H:i'),
                TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(50),
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
