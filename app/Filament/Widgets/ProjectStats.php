<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Project;
use App\Models\Survey;
use App\Models\Design;
use App\Models\Production;

class ProjectStats extends StatsOverviewWidget
{
    protected static ?int $sort = -10;
    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        return [

            Stat::make('Total Project', Project::count())
                ->color('primary'),

            Stat::make('Survey Pending', Survey::whereIn('status', ['need to survey', 'In Progress'])->count())
                ->color('warning'),

            Stat::make('Design Progress', Design::whereIn('status', ['in progress','in review'])->count())
                ->color('info'),

            Stat::make('Production', Production::where('status', 'production')->count())
                ->color('success'),

        ];
    }
}