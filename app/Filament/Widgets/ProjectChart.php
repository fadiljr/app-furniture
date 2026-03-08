<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Project;

class ProjectChart extends ChartWidget
{
    protected ?string $heading = 'Project Overview';

    protected function getData(): array
{
    return [
        'datasets' => [
            [
                'label' => 'Project Pipeline',
                'data' => [
                    \App\Models\Survey::count(),
                    \App\Models\Design::count(),
                    \App\Models\Production::count(),
                    \App\Models\Project::where('status', 'completed')->count(),
                ],

                'backgroundColor' => [
                    '#f59e0b', // survey
                    '#3b82f6', // design
                    '#10b981', // production
                    '#6366f1', // completed
                ],
            ],
        ],

        'labels' => [
            'Survey',
            'Design',
            'Production',
            'Completed',
        ],
    ];
}

    protected function getType(): string
    {
        return 'bar';
    }
}