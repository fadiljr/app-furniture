<?php

namespace App\Filament\Resources\Productions\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;

class ProductionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Hidden::make('project_id')
                            ->default(fn () => request()->get('project_id')),
                TextInput::make('project_number')
                    ->label('Project Number')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(function ($record) {
                        if ($record?->project?->project_number) {
                            return $record->project->project_number;
                        }

                        $projectId = request()->get('project_id');
                        if ($projectId) {
                            $project = \App\Models\Project::find($projectId);
                            return $project?->project_number;
                        }

                        return null;
                    }),
                TextInput::make('project_name')
                    ->label('Project Name')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(function ($record) {
                        if ($record?->project?->project_type) {
                            return $record->project->project_type;
                        }

                        $projectId = request()->get('project_id');
                        if ($projectId) {
                            $project = \App\Models\Project::find($projectId);
                            return $project?->project_type;
                        }

                        return null;
                    }),
                DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('End Date')
                    ->required(),
                Section::make('Production Tasks')
                    ->schema([
                        Repeater::make('tasks')
                            ->label('Tasks')
                            ->relationship('tasks') // Ensure this matches the relationship name in your Production model
                            ->schema([
                                TextInput::make('task_name')
                                    ->label('Task Name')
                                    ->required(),

                                TextInput::make('worker_name')
                                    ->label('Worker Name')
                                    ->required(),

                                Checkbox::make('is_done')
                                    ->label('Done'),
                            ])->columns(3)
                            ->defaultItems(1)
                            ->addActionLabel('Add Task'),
                        // Add more fields as needed
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
