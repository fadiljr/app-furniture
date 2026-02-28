<?php

namespace App\Filament\Resources\Surveys\Schemas;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Filament\Forms\Components\DateTimePicker;

class SurveyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->label('Project Number')
                    ->relationship(name: 'project', titleAttribute: 'project_number')
                    ->getOptionLabelFromRecordUsing(fn ($record) => 
                        $record->project_number
                    )
                    ->disabled()
                    ->dehydrated(false),
                Select::make('project_id')
                    ->label('Project Name')
                    ->relationship(name: 'project', titleAttribute: 'project_type')
                    ->getOptionLabelFromRecordUsing(fn ($record) => 
                        $record->project_type
                    )
                    ->disabled()
                    ->dehydrated(false),

                Select::make('project.client.name')
                    ->label('Client Name')
                    ->disabled()
                    ->dehydrated(false),

                DateTimePicker::make('survey_date')
                    ->label('Survey Date')
                     ->seconds(false)
                        ->displayFormat('d/M/Y H:i')
                        ->required(),

                TextInput::make('notes')
                    ->label('Notes')
                    ->maxLength(255),
                Select::make('status')
                    ->label('Status')
                    ->default(fn($record) => $record->status ?? 'test')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'canceled' => 'Canceled',
                    ])
                    ->required()
            ]);
    }
}
