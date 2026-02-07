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
use Filament\Schemas\Components\Fieldset;
use Illuminate\Validation\Rules\Date;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            Select::make('client_id')
                ->relationship('client', 'name')
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
                    DatePicker::make('survey_date')
                        ->label('Tanggal Survey')
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
