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
use Filament\Forms\Components\DatePicker;

class SurveyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('project.project_number')
                    ->label('Project Number')
                    ->default(fn($record) => $record->project->project_number ?? '')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('project.project_type')
                    ->label('Project Name')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('project.client.name')
                    ->label('Client Name')
                    ->disabled()
                    ->dehydrated(false),

                DatePicker::make('survey_date')
                    ->label('Survey Date')
                    ->required(),

                TextInput::make('notes')
                    ->label('Notes')
                    ->maxLength(255),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'canceled' => 'Canceled',
                    ])
                    ->required(),

                Fieldset::make('Detail Survey')
                    ->schema([
                        Tabs::make('Survey Tabs')
                            ->tabs([
                                Tab::make('Room Details')
                                    ->schema([
                                        Repeater::make('surveyRooms')
                                            ->label('Rooms')
                                            ->relationship('surveyRooms')
                                            ->minItems(1)
                                            ->defaultItems(1)
                                            ->schema([
                                                TextInput::make('room_name')
                                                    ->label('Room Name')
                                                    ->required(),

                                                TextInput::make('length')
                                                    ->label('Length (cm)')
                                                    ->numeric()
                                                    ->required(),

                                                TextInput::make('width')
                                                    ->label('Width (cm)')
                                                    ->numeric()
                                                    ->required(),

                                                TextInput::make('height')
                                                    ->label('Height (cm)')
                                                    ->numeric()
                                                    ->required(),

                                                TextInput::make('notes')
                                                    ->label('Notes')
                                                    ->maxLength(255),
                                            ]),
                                    ]),

                                Tab::make('Material Details')
                                    ->schema([
                                        TextInput::make('additional_info')
                                            ->label('Additional Information')
                                            ->maxLength(500),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
