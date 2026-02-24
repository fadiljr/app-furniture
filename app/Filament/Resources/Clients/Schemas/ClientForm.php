<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('client_code')
                ->label('Client Code')
                ->default(fn () => \App\Models\Client::generateClientCode())
                ->disabled()
                ->dehydrated(false),

            TextInput::make('name')
                ->required()
                ->maxLength(100),

            Select::make('company_id')
                ->label('Company')
                ->relationship('company', 'name')
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('phone'),

            Textarea::make('address'),
            

        ]);
    }
}
