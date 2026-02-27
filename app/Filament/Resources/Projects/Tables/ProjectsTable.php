<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\ViewAction;

class ProjectsTable
{
    public static function configure(Table $table): Table 
    {
        return $table
            ->columns([
                TextColumn::make('project_number')
                    ->label('Project Number')
                    ->searchable(),
                TextColumn::make('client.name')
                    ->label('Client Name')
                    ->searchable(),

                TextColumn::make('project_type')
                    ->label('Project Type')
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->searchable(),

                TextColumn::make('surveys.survey_date')
                    ->label('Survey Date')
                    ->dateTime('d/M/Y H:i')
                    ->sortable(),
            ])
            ->actions([
                // Action::make('view')
                //     ->label('Detail')
                //     ->icon('heroicon-o-eye'),

                ViewAction::make(),

                EditAction::make(),

                // Action::make('openMap')
                //     ->label('Open Map')
                //     ->icon('heroicon-o-map')
                //     ->url(fn ($record) => $record->address)
                //     ->openUrlInNewTab(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
