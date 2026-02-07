<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('name')->required(),

            TextInput::make('phone'),

            Textarea::make('address'),

        ]);
    }
}
