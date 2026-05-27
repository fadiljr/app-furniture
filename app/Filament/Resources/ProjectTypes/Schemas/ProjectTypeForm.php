<?php

namespace App\Filament\Resources\ProjectTypes\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class ProjectTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')->required()->unique(ignoreRecord: true),
                TextInput::make('description'),
            ]);
    }
}
