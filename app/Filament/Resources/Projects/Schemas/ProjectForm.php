<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

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
                    fn() => \App\Models\Project::generateProjectNumber()
                ),

            Select::make('client_id')
                ->label('Client')
                ->relationship(
                    name: 'client',
                    titleAttribute: 'name'
                )
                ->getOptionLabelFromRecordUsing(
                    fn($record) =>
                    $record->client_code . ' - ' . $record->name . ' - ' . $record->phone
                )
                ->required()
                ->searchable()
                ->preload(),

            TextInput::make('project_type')
                ->required(),
            Textarea::make('address')
                ->required()
                ->placeholder('Enter address or copy paste from google maps')
                ->maxLength(255),
            Textarea::make('description')
                ->maxLength(255),
        ]);
    }
}
