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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Laravel\Pail\File;

class SurveyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('project.project_number')
                    ->label('Project Number')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(fn ($record) => $record?->project?->project_number),
                TextInput::make('project.project_type')
                    ->label('Project Name')
                    ->relationship(name: 'project', titleAttribute: 'project_type')
                    ->getOptionLabelFromRecordUsing(fn ($record) => 
                        $record->project_type
                    )
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(fn ($record) => $record?->project?->project_type),
                TextInput::make('client.name')
                    ->label('Client Name')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(fn ($record) => $record?->project?->client?->name),
                TextInput::make('status')
                        ->label('Status')
                        ->disabled()
                        ->dehydrated(false),

                DateTimePicker::make('survey_date')
                    ->label('Survey Date')
                     ->seconds(false)
                        ->displayFormat('d/M/Y H:i')
                        ->required(),

                Textarea::make('notes')
                    ->label('Notes')
                    ->maxLength(255),
                FileUpload::make('attachments')
                    ->label('Attachments')
                    ->multiple()
                    ->disk('public')
                    ->directory('survey-attachments')
                    ->preserveFilenames()
                    ->openable()
                    ->downloadable()
                    ->dehydrated(false),
            ]);
    }
}
