<?php

namespace App\Filament\Resources\Designs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;

class DesignForm
{
    public static function configure(Schema $schema): Schema
{
    return $schema
        ->components([
            TextInput::make('design_id')
                ->disabled()
                ->dehydrated(false),

            FileUpload::make('file_path')
                ->label('Upload Design Files')
                ->disk('public')
                ->directory('designs')
                ->multiple()
                ->reorderable()
                ->previewable()
                ->openable()
                ->downloadable()
                ->imagePreviewHeight('150')
                ->panelLayout('grid')
                ->required(),

            Textarea::make('description')
                ->label('Deskripsi')
                ->rows(4)
                ->columnSpanFull(),

            Select::make('status')
                ->options([
                    'requested' => 'Design Requested',
                    'in_progress' => 'In Progress',
                    'in_review' => 'In Review',
                    'revision' => 'Revision Required',
                    'approved' => 'Approved',
                ])
                ->default('requested')
                ->required(),

            DatePicker::make('deadline')
                ->required(),
        ]);
}
}
