<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use App\Filament\Resources\Projects\ProjectResource;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->label('client name')
                    ->searchable(),

                TextColumn::make('project_type')
                    ->label('Jenis'),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('created_at')
                    ->date(),
            ])
            ->actions([
                Action::make('view')
                    ->label('Detail')
                    ->icon('heroicon-o-eye'),

                EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
