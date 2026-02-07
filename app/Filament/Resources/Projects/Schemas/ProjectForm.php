<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Schemas\Schema;
// use Filament\Forms;
// use Filament\Forms\Form;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Material;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

        Wizard::make([

            // ================= STEP 1 =================
            Step::make('Data Project')
                ->schema([

                    Select::make('client_id')
                        ->relationship('client', 'name')
                        ->required()
                        ->searchable()
                        ->preload(),

                    TextInput::make('project_type')
                        ->required(),

                    Textarea::make('address'),

                    TextInput::make('size')
                        ->label('Ukuran'),

                ]),

            // ================= STEP 2 =================
            Step::make('Estimasi Material')
                ->schema([

                    Repeater::make('materialEstimations')
                        ->relationship()
                        ->schema([

                            Select::make('material_id')
                                ->relationship('material', 'name')
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, $set) {
                                    $material = Material::find($state);

                                    if ($material) {
                                        $set('unit', $material->unit);
                                        $set('estimated_price', $material->price);
                                    }
                                }),

                            Hidden::make('unit'),

                            TextInput::make('qty_estimated')
                                ->numeric()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, $set, $get) {
                                    $set('subtotal', ($state ?? 0) * ($get('estimated_price') ?? 0));
                                }),

                            TextInput::make('estimated_price')
                                ->numeric()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, $set, $get) {
                                    $set('subtotal', ($get('qty_estimated') ?? 0) * ($state ?? 0));
                                }),

                            TextInput::make('subtotal')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(),

                        ])
                        ->columns(4)
                        ->defaultItems(1)
                        ->afterStateUpdated(function ($state, $set) {
                            $total = collect($state)->sum('subtotal');
                            $set('../../estimated_cost', $total);
                        }),

                ]),

            // ================= STEP 3 =================
            Step::make('Ringkasan Biaya')
                ->schema([

                    TextInput::make('estimated_cost')
                        ->numeric()
                        ->label('Total Estimasi Proyek')
                        ->required(),

                ]),

        ])->columnSpanFull()

        ]);
    }
}
