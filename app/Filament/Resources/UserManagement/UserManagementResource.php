<?php

namespace App\Filament\Resources\UserManagement;

use App\Filament\Resources\UserManagement\Pages\CreateUserManagement;
use App\Filament\Resources\UserManagement\Pages\EditUserManagement;
use App\Filament\Resources\UserManagement\Pages\ListUserManagement;
use App\Filament\Resources\UserManagement\Schemas\UserManagementForm;
use App\Filament\Resources\UserManagement\Tables\UserManagementTable;
use App\Models\UserManagement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserManagementResource extends Resource
{
    protected static ?string $model = UserManagement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'User';

    public static function form(Schema $schema): Schema
    {
        return UserManagementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserManagementTable::configure($table);
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
            'index' => ListUserManagement::route('/'),
            'create' => CreateUserManagement::route('/create'),
            'edit' => EditUserManagement::route('/{record}/edit'),
        ];
    }
}
