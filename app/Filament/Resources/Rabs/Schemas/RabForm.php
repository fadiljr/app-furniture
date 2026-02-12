<?php

namespace App\Filament\Resources\Rabs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
class RabForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
               ->components([

                Section::make('Informasi RAB')
                    ->schema([

                        Select::make('project_id')
                            ->relationship('project', 'project_type')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('nomor_rab')
                            ->required()
                            ->default(fn () => 'RAB-' . now()->format('YmdHis')),

                        DatePicker::make('tanggal')
                            ->required()
                            ->default(now()),

                        DatePicker::make('expired_date'),

                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'dikirim' => 'Dikirim',
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak',
                            ])
                            ->default('draft')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Item RAB')
                ->schema([
                Repeater::make('items')
                    ->relationship()
                    ->schema([

                        TextInput::make('nama_item')
                            ->required(),

                        TextInput::make('satuan'),

                        TextInput::make('volume')
                            ->numeric()
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($get, $set) {
                                $total = ($get('volume') ?? 0) * ($get('harga_satuan') ?? 0);
                                $set('total', $total);
                            }),

                        TextInput::make('harga_satuan')
                            ->numeric()
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($get, $set) {
                                $total = ($get('volume') ?? 0) * ($get('harga_satuan') ?? 0);
                                $set('total', $total);
                            }),

                        TextInput::make('total')
                            ->numeric()
                            ->readOnly(), // ✅ jangan pakai disabled
                    ])
                    ->live()
                    ->afterStateUpdated(function ($state, $get, $set) {

                        $subtotal = collect($state)
                            ->sum(fn ($item) => 
                                ($item['volume'] ?? 0) * ($item['harga_satuan'] ?? 0)
                            );

                        $set('subtotal', $subtotal);

                        // hitung ulang grand total
                        $diskon = $get('diskon') ?? 0;
                        $pajakPersen = $get('pajak') ?? 0;

                        $dpp = $subtotal - $diskon;
                        $pajakNominal = $dpp * ($pajakPersen / 100);

                        $set('grand_total', $dpp + $pajakNominal);
                    })
                    ]),

                Section::make('Ringkasan')
                    ->schema([

                        TextInput::make('subtotal')
                            ->numeric()
                            ->readOnly()
                            ->default(0),

                        TextInput::make('diskon')
                            ->numeric()
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $get, $set) {

                                $subtotal = $get('subtotal') ?? 0;
                                $pajakPersen = $get('pajak') ?? 0;

                                $dpp = $subtotal - $state;
                                $pajakNominal = $dpp * ($pajakPersen / 100);

                                $set('grand_total', $dpp + $pajakNominal);
                            }),

                        TextInput::make('pajak')
                            ->numeric()
                            ->default(0)
                            ->helperText('Dalam persen (%)')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $get, $set) {

                                $subtotal = $get('subtotal') ?? 0;
                                $diskon = $get('diskon') ?? 0;

                                $dpp = $subtotal - $diskon;
                                $pajakNominal = $dpp * ($state / 100);

                                $set('grand_total', $dpp + $pajakNominal);
                            }),

                        TextInput::make('grand_total')
                            ->numeric()
                            ->readOnly()
                            ->default(0),
                    ])
                    ->columns(2),

            ]);
    }
}