<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('name')
                ->required()
                ->maxLength(100),

            TextInput::make('phone'),

            Textarea::make('address'),

        ]);
    }
}
