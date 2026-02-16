<?php

namespace App\Filament\Resources\PriceLists\Schemas;

use Dom\Text;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

use function Laravel\Prompts\text;

class PriceListForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('item_name')
                    ->label('Item Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0),
                Select::make('unit')
                    ->label('Unit')
                    ->options([
                        'pcs' => 'pcs',
                        'm1' => 'm1',
                        'm2' => 'm2',
                    ])
                    ->required(),
                TextInput::make('description')
                    ->label('Description')
                    ->maxLength(500),
            ]);
    }
}
