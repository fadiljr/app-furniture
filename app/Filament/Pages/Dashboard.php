<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?int $navigationSort = -2;

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\ProjectStats::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\ProjectChart::class,
            \App\Filament\Widgets\LatestProjects::class,
        ];
    }
}