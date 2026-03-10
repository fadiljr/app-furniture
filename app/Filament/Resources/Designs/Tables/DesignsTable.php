<?php

namespace App\Filament\Resources\Designs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Columns\BadgeColumn;

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

                TextColumn::make('project.project_number')
                    ->label('Project Number')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->icon(fn (string $state): string => match ($state) {
                        'requested' => 'heroicon-o-clock',
                        'in progress' => 'heroicon-o-cog',
                        'in review' => 'heroicon-o-eye',
                        'approved' => 'heroicon-o-check',
                        'revision' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-information-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'requested' => 'warning',
                        'in progress' => 'primary',
                        'in review' => 'info',
                        'approved' => 'success',
                        'revision' => 'danger',
                        default => 'secondary',
                    }),
                TextColumn::make('deadline')
                    ->label('Deadline')
                    ->formatStateUsing(fn($state) => $state?->format('d M Y'))
                    ->badge()
                    ->colors([
                        'danger' => fn($record) =>
                        $record->deadline &&
                            $record->deadline->isPast() &&
                            $record->status !== 'approved',
                        'gray' => fn($record) =>
                        $record->deadline &&
                            $record->deadline->isFuture(),
                        'success' => fn($record) =>
                        $record->status === 'approved',
                    ])

            ])

            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([

                    Action::make('preview')
                        ->label('Preview')
                        ->icon('heroicon-o-eye')
                        ->modalHeading('Preview Design Files')
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('Tutup')
                        ->modalWidth('5xl')
                        ->modalContent(fn($record) => view(
                            'filament.designs.preview-modal',
                            ['files' => $record->file_path]
                        )),

                    EditAction::make()
                    ->modal()
                    ->modalHeading('Edit Design')
                    ->modalSubmitActionLabel('Save')
                    ->visible(fn($record) => $record->status == 'requested' or $record->status == 'in progress' or $record->status == 'revision'),
                    Action::make('inProgress')
                        ->label('In Progress')
                        ->icon('heroicon-o-arrow-trending-up')
                        ->color('warning')
                        ->visible(fn($record) => $record->status == 'requested' or $record->status == 'revision')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'in progress',
                            ]);
                        }),
                    Action::make('inReview')
                        ->label('Send to Review')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->visible(fn($record) => $record->status == 'in progress')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'in review',
                            ]);
                        }),
                    Action::make('approve')
                        ->label('Approve')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->visible(fn($record) => $record->status == 'in review')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'approved',
                            ]);
                            if($project = $record->project) {
                                $project->update([
                                    'status' => 'Design Approved',
                                ]);
                            }
                        }),
                    Action::make('requestRevision')
                        ->label('Request Revision')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn($record) => $record->status == 'in review')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'revision',
                            ]);
                        }),
                ]),
            ]);
    }
}
