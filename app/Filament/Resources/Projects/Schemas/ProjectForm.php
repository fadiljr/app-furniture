<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Schemas\Schema;
// use Filament\Forms;
// use Filament\Forms\Form;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Material;
use DateTime;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Fieldset;
use Illuminate\Validation\Rules\Date;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('project_number')
                ->label('Project Number')
                ->disabled()
                ->dehydrated(false)
                ->default(
                    fn () => \App\Models\Project::generateProjectNumber()
                ),

            Select::make('client_id')
                ->label('Client')
                ->relationship(
                    name: 'client',
                    titleAttribute: 'name'
                )
                ->getOptionLabelFromRecordUsing(fn ($record) => 
                    $record->client_code . ' - ' . $record->name . ' - ' . $record->phone
                )
                ->required()
                ->searchable()
                ->preload(),

            TextInput::make('project_type')
                ->required(),
            Textarea::make('address')
                ->required()
                ->maxLength(100),
            Textarea::make('description')
                ->maxLength(255),

            Fieldset::make('Survey')
                ->relationship('surveys')
                ->schema([
                    DateTimePicker::make('survey_date')
                        ->label('Tanggal Survey')
                        ->seconds(false)
                        ->displayFormat('d/M/Y H:i')
                        ->required(),

                    Textarea::make('notes')
                        ->label('Catatan Survey')
                        ->rows(3)
                        ->maxLength(255),
                ])
                ->columns(1),
        ]);
    }
}
