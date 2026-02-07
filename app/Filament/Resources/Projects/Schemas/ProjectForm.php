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
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Material;

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

        ]);
    }
}
