<?php

namespace App\Filament\Resources\Designs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Placeholder;

class DesignForm
{
    public static function configure(Schema $schema): Schema
{
    return $schema
        ->components([
            Section::make('Survey Information')
                    ->columnSpanFull()
                    ->schema([
                        TextArea::make('notes')
                            ->label('Survey Notes')
                            ->disabled()
                            ->dehydrated(false)
                            ->formatStateUsing(fn ($record) => $record?->project?->surveys?->notes),
                        Placeholder::make('survey_attachments')
                            ->label('Survey Attachments')
                            ->content(function ($record) {
                                $attachments = $record?->project?->surveys?->attachments ?? [];

                                if (empty($attachments)) {
                                    return 'No attachments';
                                }

                                if (is_string($attachments)) {
                                    $attachments = json_decode($attachments, true) ?? [];
                                }

                                $links = collect($attachments)->map(function ($file) {
                                    $url = \Illuminate\Support\Facades\Storage::url($file);
                                    // $name = basename($file);
                                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                                    $icon = '📎';

                                    if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                                        $icon = '🖼️';
                                    } elseif ($ext === 'pdf') {
                                        $icon = '📄';
                                    } elseif (in_array($ext, ['doc','docx'])) {
                                        $icon = '📝';
                                    } elseif (in_array($ext, ['xls','xlsx','csv'])) {
                                        $icon = '📊';
                                    } elseif (in_array($ext, ['zip','rar'])) {
                                        $icon = '🗜️';
                                    }

                                    return "<a href='{$url}' target='_blank' class='flex items-center gap-2 text-primary-600 underline'>
                                                <span>{$icon}</span>
                                                <span>Attachment.{$ext}</span>
                                            </a>";
                                })->implode('<br>');

                                return new \Illuminate\Support\HtmlString($links);
                            })
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
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
                ->label('Design Description')
                ->placeholder('Enter a description for the design...')
                ->rows(4)
                ->columnSpanFull(),
        ]);
}
}
