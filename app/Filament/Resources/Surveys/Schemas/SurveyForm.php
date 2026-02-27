<?php

namespace App\Filament\Resources\Surveys\Schemas;

use App\Models\Project;
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

class SurveyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('project_number')
                    ->label('Project Number')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(fn($record) => $record?->project?->project_number),

                TextInput::make('project_type')
                    ->label('Project Name')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(fn($record) => $record?->project?->project_type),

                TextInput::make('client_name')
                    ->label('Client Name')
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(fn($record) => $record?->project?->client?->name),
                TextInput::make('status')
                    ->label('Status')
                    ->disabled(),

                DateTimePicker::make('survey_date')
                    ->label('Survey Date')
                    ->seconds(false)
                    ->displayFormat('d/M/Y H:i')
                    ->required(),

                TextInput::make('notes')
                    ->label('Notes')
                    ->maxLength(255),

                FileUpload::make('attchments')
                    ->multiple()
                    ->directory('surveys')
                    ->disk('public')
                    ->visibility('public')
                    ->openable()
                    ->downloadable()
                    ->previewable()
            ]);
    }
}
