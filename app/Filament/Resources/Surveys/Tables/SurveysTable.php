<?php

namespace App\Filament\Resources\Surveys\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ActionGroup;
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
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn (string $state): string => match ($state) {
                        'need to survey' => 'heroicon-o-clock',
                        'In Progress' => 'heroicon-o-cog',
                        'Completed' => 'heroicon-o-check-circle',
                        'Canceled' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-information-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'need to survey' => 'warning',
                        'In Progress' => 'primary',
                        'Completed' => 'success',
                        'Canceled' => 'danger',
                        default => 'secondary',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordUrl(null)
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make()
                        ->modal()
                        ->modalHeading('Edit Survey')
                        ->modalSubmitActionLabel('Save')
                        ->visible(fn ($record) => $record->status == 'In Progress'),
                    Action::make('inProgress')
                        ->label('In Progress')
                        ->icon('heroicon-o-clock')
                        ->color('warning')
                        ->visible(fn ($record) => $record->status == 'need to survey')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'In Progress',
                            ]);
                        }),
                    Action::make('canceled')
                        ->label('Canceled')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn ($record) => $record->status == 'need to survey')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'Canceled',
                            ]);
                            if($record->project) {
                                $record->project->update([
                                    'status' => 'Canceled',
                                ]);
                            }
                        }),
                    Action::make('completed')
                        ->label('Completed')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => $record->status == 'In Progress')
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'Completed',
                            ]);
                            if($record->project) {
                                $record->project->update([
                                    'status' => 'Completed survey',
                                ]);
                            }
                        }),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
