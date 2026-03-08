<?php

namespace App\Filament\Resources\PurchaseOrders\Schemas;

use Dom\Text;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PurchaseOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Hidden::make('production_id')
                    ->default(request()->query('production_id')),
                TextInput::make('project.project_number')
                    ->label('Project Number')
                    ->formatStateUsing(fn ($record) => $record?->production?->project?->project_number)
                    ->disabled(),
            ]);
    }
}
