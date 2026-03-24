<?php

namespace App\Filament\Resources\PurchaseOrders\Schemas;

use Dom\Text;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput\Mask;

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
                    ->formatStateUsing(function ($record) {
                        if ($record?->production?->project) {
                            return $record?->production?->project?->project_number;;
                        }
                        $productionId = request()->get('production_id');

                        if ($productionId) {
                            $production = \App\Models\Production::find($productionId);
                            return $production?->project?->project_number;
                        }

                        return null;
                    })
                    ->disabled()
                    ->dehydrated(false),
                Select::make('supplier_id')
                    ->label('Supplier')
                    ->options(function () {
                        return \App\Models\Supplier::pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),
                TextInput::make('order_date')
                    ->label('Order Date')
                    ->type('date')
                    ->required(),
                TextInput::make('total_amount')
                    ->label('Total Amount')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(true)
                    ->default(0),
                Section::make('Order Items')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('items')
                            ->relationship('items')
                            ->columns(4)
                            ->schema([
                                Select::make('material_id')
                                    ->label('Item')
                                    ->options(function () {
                                        return \App\Models\Material::pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('qty')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->reactive()
                                    ->default(0)
                                    ->live()
                                    ->required()
                                    ->afterStateUpdated(function ($get, $set) {
                                        $items = $get('../../items') ?? [];
                                        $total = 0;

                                        foreach ($items as $item) {
                                            $qty = (int) str_replace('.', '', ($item['qty'] ?? 0));
                                            $price = (float) str_replace('.', '', ($item['price'] ?? 0));
                                            $total += $qty * $price;
                                        }

                                        $set('../../total_amount', $total);

                                        $currentQty = $get('qty') ?? 0;
                                        $currentPrice = (float) str_replace('.', '', ($get('price') ?? 0));
                                        $set('subtotal', $currentQty * $currentPrice);
                                    })
                                    ->columnSpan(1),
                                TextInput::make('price')
                                    ->label('Unit Price')
                                    ->numeric()
                                    ->reactive()
                                    ->default(0)
                                    ->live()
                                    ->required() 
                                    ->afterStateUpdated(function ($get, $set) {
                                        $items = $get('../../items') ?? [];
                                        $total = 0;

                                        foreach ($items as $item) {
                                            $qty = (int) ($item['qty'] ?? 0);
                                            $price = (float) ($item['price'] ?? 0);
                                            $total += $qty * $price;
                                        }

                                        $set('../../total_amount', $total);

                                        $currentQty = $get('qty') ?? 0;
                                        $currentPrice = (float) ($get('price') ?? 0);
                                        $set('subtotal', $currentQty * $currentPrice);
                                    })
                                    ->columnSpan(1),
                                TextInput::make('subtotal')
                                    ->label('Sub Total')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->columnSpan(1),
                            ])
                            ->addActionLabel('Add Item'),
                    ]),
            ]);
    }
}
