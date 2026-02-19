<?php

namespace App\Filament\Resources\Rabs;

use App\Filament\Resources\Rabs\Pages\CreateRab;
use App\Filament\Resources\Rabs\Pages\EditRab;
use App\Filament\Resources\Rabs\Pages\ListRabs;
use App\Filament\Resources\Rabs\Schemas\RabForm;
use App\Filament\Resources\Rabs\Tables\RabsTable;
use App\Models\Rab;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RabResource extends Resource
{
    protected static ?string $model = Rab::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    protected static ?string $recordTitleAttribute = 'RAB';
    protected static ?string $label = 'Quotation List'; 

    public static function form(Schema $schema): Schema
    {
        return RabForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RabsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRabs::route('/'),
            'create' => CreateRab::route('/create'),
            'edit' => EditRab::route('/{record}/edit'),
        ];
    }
}
