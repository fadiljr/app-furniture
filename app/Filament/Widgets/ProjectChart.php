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
                    'label' => 'Projects',
                    'data' => [
                        Project::where('status','in progress survey')->count(),
                        Project::where('status','design')->count(),
                        Project::where('status','production')->count(),
                        Project::where('status','completed')->count(),
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