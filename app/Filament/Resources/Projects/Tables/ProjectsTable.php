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
                TextColumn::make('client.name')
                    ->label('Client Name')
                    ->searchable(),

                TextColumn::make('project_type')
                    ->label('Project Type')
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created Date')
                    ->date()
                    ->searchable(),
            ])
            ->actions([
                // Action::make('view')
                //     ->label('Detail')
                //     ->icon('heroicon-o-eye'),

                ViewAction::make(),

                EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
