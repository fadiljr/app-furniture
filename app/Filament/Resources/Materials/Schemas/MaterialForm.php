<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('name')
                ->required(),

            TextInput::make('unit')
                ->label('Satuan')
                ->placeholder('lembar / kg / m2'),

            TextInput::make('stock')
                ->numeric()
                ->default(0),

            TextInput::make('price')
                ->numeric()
                ->label('Harga Satuan'),

        ]);
    }
}
