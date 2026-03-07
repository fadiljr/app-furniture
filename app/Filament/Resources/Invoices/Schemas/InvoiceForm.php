<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Dom\Text;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('invoice_number')
                    ->label('Invoice Number')
                    ->required(),
                DatePicker::make('invoice_date')
                    ->label('Invoice Date')
                    ->required()
                    ->date(),
                TextInput::make('total_amount')
                    ->label('Total Amount')
                    ->required()
            ]);
    }
}
