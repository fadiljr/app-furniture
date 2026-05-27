<?php

namespace App\Filament\Resources\Productions\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;

class ProductionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                // Section::make('Desain Project')
                //     ->schema([
                //         Placeholder::make('design_attachments')
                //             ->label('Design Attachments')
                //             ->content(function ($record) {
                //                 $attachments = $record?->project?->designs
                //                     ?->pluck('file_path')
                //                     ->map(function ($item) {
                //                         if (is_string($item)) {
                //                             $decoded = json_decode($item, true);
                //                             return is_array($decoded) ? $decoded : [];
                //                         }
                //                         return is_array($item) ? $item : [];
                //                     })
                //                     ->flatten()
                //                     ->filter()
                //                     ->values()
                //                     ->all() ?? [];

                //                 if (empty($attachments)) {
                //                     return 'No attachments';
                //                 }

                //                 $links = collect($attachments)->map(function ($file) {
                //                     $url = \Illuminate\Support\Facades\Storage::url($file);
                //                     // $name = basename($file);
                //                     $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                //                     $icon = '📎';

                //                     if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                //                         $icon = '🖼️';
                //                     } elseif ($ext === 'pdf') {
                //                         $icon = '📄';
                //                     } elseif (in_array($ext, ['doc','docx'])) {
                //                         $icon = '📝';
                //                     } elseif (in_array($ext, ['xls','xlsx','csv'])) {
                //                         $icon = '📊';
                //                     } elseif (in_array($ext, ['zip','rar'])) {
                //                         $icon = '🗜️';
                //                     }

                //                     return "<a href='{$url}' target='_blank' class='flex items-center gap-2 text-primary-600 underline'>
                //                                 <span>{$icon}</span>
                //                                 <span>Attachment.{$ext}</span>
                //                             </a>";
                //                 })->implode('<br>');

                //                 return new \Illuminate\Support\HtmlString($links);
                //             })
                //             ->columnSpanFull(),
                //     ])
                //     ->columnSpanFull(),

                // Hidden::make('project_id')
                //             ->default(fn () => request()->get('project_id')),
                TextInput::make('project_number')
                    ->label('Project Number')
                    ->disabled()
                    ->dehydrated(false)
                    ->default(
                        fn() => \App\Models\Project::generateProjectNumber()
                    ),
                Select::make('project.projectTypes')
                    ->relationship('projectTypes', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('End Date')
                    ->required(),
                Section::make('Production Tasks')
                    ->schema([
                        Repeater::make('tasks')
                            ->label('Tasks')
                            ->relationship('tasks') // Ensure this matches the relationship name in your Production model
                            ->schema([
                                TextInput::make('task_name')
                                    ->label('Task Name')
                                    ->required(),

                                TextInput::make('worker_name')
                                    ->label('Worker Name')
                                    ->required(),

                                Checkbox::make('is_done')
                                    ->label('Done'),
                            ])->columns(3)
                            ->defaultItems(1)
                            ->addActionLabel('Add Task'),
                        // Add more fields as needed
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
