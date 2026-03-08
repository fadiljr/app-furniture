<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Project;

class ProjectStats extends StatsOverviewWidget
{
    protected static ?int $sort = -10;
    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        return [

            Stat::make('Total Project', Project::count())
                ->description('Semua project')
                ->color('primary'),

            Stat::make('Survey Pending', Project::where('status', 'survey')->count())
                ->color('warning'),

            Stat::make('Design Progress', Project::where('status', 'design')->count())
                ->color('info'),

            Stat::make('Production', Project::where('status', 'production')->count())
                ->color('success'),

        ];
    }
}