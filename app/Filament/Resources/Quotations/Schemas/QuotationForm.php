<?php

namespace App\Filament\Resources\Quotations\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Checkbox;

class QuotationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Quotation Information')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('quotation_number')
                            ->label('Quotation Number')
                            ->disabled()
                            ->dehydrated(false)
                            ->default(fn () => \App\Models\Quotation::generateQuotationNumber()),

                        TextInput::make('client_name')
                            ->label('Client Name')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('client_address')
                            ->label('Client Address')
                            ->rows(3),

                        DatePicker::make('quotation_date')
                            ->label('Quotation Date')
                            ->required(),

                        DatePicker::make('valid_until')
                            ->label('Valid Until'),
                    ])
                    ->columns(2),

                Section::make('Items')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                TextInput::make('item_name')
                                    ->label('Item Name')
                                    ->required()
                                    ->columnSpan(2),
                                
                                Checkbox::make('use_prorate')
                                    ->label('Use Prorate')
                                    ->live()
                                    ->columnSpan(1)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $length = (float) $get('length');
                                        $unitPrice = (float) $get('unit_price');

                                        // If unchecked, prorate_value is ignored and subtotal uses standard formula
                                        if (!$state) {
                                            $set('prorate_value', 0);
                                        }

                                        $subtotal = $length * $unitPrice;
                                        $set('subtotal', round($subtotal, 2));
                                    }),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->rows(2)
                                    ->columnSpan(2),

                                TextInput::make('length')
                                    ->label('Length (m1)')
                                    ->numeric()
                                    ->step(0.01)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $length = (float) $state;
                                        $value = (float) $get('value');
                                        $prorate = (float) $get('prorate_value');
                                        $unitPrice = (float) $get('unit_price');
                                        $useProrate = $get('use_prorate');

                                        if ($length > 0 && $unitPrice > 0) {
                                            if ($useProrate && $value > 0) {
                                                $subtotal = ($prorate / $value) * $length * $unitPrice;
                                            } else {
                                                $subtotal = $length * $unitPrice;
                                            }
                                            $set('subtotal', round($subtotal, 2));
                                        }
                                    })
                                    ->required(),

                                TextInput::make('value')
                                    ->label('Value (cm)')
                                    ->numeric()
                                    ->step(0.01)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $length = (float) $get('length');
                                        $value = (float) $state;
                                        $prorate = (float) $get('prorate_value');
                                        $unitPrice = (float) $get('unit_price');
                                        $useProrate = $get('use_prorate');

                                        if ($length > 0 && $unitPrice > 0) {
                                            if ($useProrate && $value > 0) {
                                                $subtotal = ($prorate / $value) * $length * $unitPrice;
                                            } else {
                                                $subtotal = $length * $unitPrice;
                                            }
                                            $set('subtotal', round($subtotal, 2));
                                        }
                                    })
                                    ->required(),

                                TextInput::make('prorate_value')
                                    ->label('Prorate Value (cm)')
                                    ->numeric()
                                    ->step(0.01)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $length = (float) $get('length');
                                        $value = (float) $get('value');
                                        $prorate = (float) $state;
                                        $unitPrice = (float) $get('unit_price');
                                        $useProrate = $get('use_prorate');

                                        if ($length > 0 && $unitPrice > 0) {
                                            if ($useProrate && $value > 0) {
                                                $subtotal = ($prorate / $value) * $length * $unitPrice;
                                            } else {
                                                $subtotal = $length * $unitPrice;
                                            }
                                            $set('subtotal', round($subtotal, 2));
                                        }
                                    })
                                    ->visible(fn ($get) => $get('use_prorate'))
                                    ->required(fn ($get) => $get('use_prorate')),

                                Select::make('unit')
                                    ->label('Unit')
                                    ->options([
                                        'm1' => 'm1',
                                        'm2' => 'm2',
                                        'unit' => 'Unit',
                                    ])
                                    ->required(),

                                TextInput::make('unit_price')
                                    ->label('Unit Price')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $length = (float) $get('length');
                                        $value = (float) $get('value');
                                        $prorate = (float) $get('prorate_value');
                                        $unitPrice = (float) $state;
                                        $useProrate = $get('use_prorate');

                                        if ($length > 0 && $unitPrice > 0) {
                                            if ($useProrate && $value > 0) {
                                                $subtotal = ($prorate / $value) * $length * $unitPrice;
                                            } else {
                                                $subtotal = $length * $unitPrice;
                                            }
                                            $set('subtotal', round($subtotal, 2));
                                        }
                                    })
                                    ->required(),

                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated(false),
                            ])
                            ->columns(3)
                            ->defaultItems(1)
                            ->addActionLabel('Add Item'),
                    ]),

                Section::make('Summary')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('total_amount')
                            ->label('Total')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),

                        TextInput::make('discount')
                            ->label('Discount')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),

                        TextInput::make('tax')
                            ->label('Tax')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),

                        TextInput::make('grand_total')
                            ->label('Grand Total')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),

                        Textarea::make('notes')
                            ->label('Notes')
                            ->columnSpanFull(),
                    ])
                    ->columns(4),
            ])
            ->columns(1);
    }
}
