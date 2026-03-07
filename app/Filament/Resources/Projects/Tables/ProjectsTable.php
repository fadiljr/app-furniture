<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DateTimePicker;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Quotations\QuotationResource;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project_number')
                    ->label('Project Number')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('project_type')
                    ->label('Project Type')
                    ->searchable(),

                TextColumn::make('client.name')
                    ->label('Client Name')
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),

                    EditAction::make()
                        ->modal()
                        ->modalHeading('Edit Project')
                        ->modalSubmitActionLabel('Save'),
                    Action::make('createScheduleSurvey')
                        ->label('Create Schedule Survey')
                        ->icon('heroicon-o-calendar-days')
                        ->modal()
                        ->modalHeading('Create Schedule Survey')
                        ->modalSubmitActionLabel('Create')
                        ->visible(fn ($record) => $record->status == 'new')
                        ->form([
                            DateTimePicker::make('survey_date')
                                ->label('Survey Schedule')
                                ->required(),
                        ])
                        ->action(function ($record, array $data) {
                            \App\Models\Survey::create([
                                'project_id' => $record->id,
                                'survey_date' => $data['survey_date'],
                            ]);
                            $record->update([
                                'status' => 'in progress survey',
                            ]);
                        }),
                    Action::make('createDeadlineDesign')
                        ->label('Create Deadline Design')
                        ->icon('heroicon-o-calendar-days')
                        ->modal()
                        ->modalHeading('Create Deadline Design')
                        ->modalSubmitActionLabel('Create')
                        ->visible(fn ($record) => $record->status == 'Quotation Approved')
                        ->form([
                            DateTimePicker::make('deadline')
                                ->label('Design Deadline')
                                ->required(),
                        ])
                        ->action(function ($record, array $data) {
                            \App\Models\Design::create([
                                'project_id' => $record->id,
                                'design_id' => \App\Models\Design::generateDesignNumber(),
                                'deadline' => $data['deadline'],
                            ]);
                            $record->update([
                                'status' => 'in progress design',
                            ]);
                        }),
                        Action::make('createQuotation')
                        ->label('Create Quotation')
                        ->icon('heroicon-o-document-text')
                        ->visible(fn ($record) => $record->status == 'Completed survey')
                        ->url(fn ($record) => QuotationResource::getUrl('create', ['project_id' => $record->id])),
                ]),
                Action::make('openMap')
                    ->label('Open Map')
                    ->icon('heroicon-o-map')
                    ->url(fn ($record) => $record->address)
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('created_at', 'desc')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
