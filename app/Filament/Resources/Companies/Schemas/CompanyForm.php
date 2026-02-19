<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Company Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Company Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('company_code')
                            ->label('Company Code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100),

                        Textarea::make('address')
                            ->label('Address')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}

