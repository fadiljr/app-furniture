<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Project;

class LatestProjects extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Project::query()->latest()->limit(5))
            ->columns([
    \Filament\Tables\Columns\TextColumn::make('project_number')
        ->label('Project'),

    \Filament\Tables\Columns\TextColumn::make('client.name')
        ->label('Client'),

    \Filament\Tables\Columns\TextColumn::make('status')
        ->badge()
        ->color(fn (string $state): string => match ($state) {
            'Completed survey' => 'success',
            'in progress production' => 'warning',
            'in progress design' => 'warning',
            'in progress survey' => 'warning',
            'Quotation Approved' => 'success',
            'Quotation Rejected' => 'danger',
            'survey completed' => 'success',
            'production completed' => 'success',
            'design completed' => 'success',
            'completed' => 'success',
            'Canceled' => 'danger',
            default => 'secondary',
        }),

    \Filament\Tables\Columns\TextColumn::make('created_at')
        ->label('Created')
        ->date(),
        ]);
    }
}
