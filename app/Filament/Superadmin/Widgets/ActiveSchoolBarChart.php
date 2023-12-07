<?php

namespace App\Filament\Superadmin\Widgets;

use Filament\Widgets\ChartWidget;

class ActiveSchoolBarChart extends ChartWidget
{
    protected static ?string $heading = 'Yearly Snapshot of Active Schools';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = "full";

    protected function getData(): array
    {
        $data = annualActiveSchoolCount();
        return [
            'datasets' => [
                [
                    'label' => 'Active Schools',
                    'data' => array_values($data),
                    'backgroundColor' => generateColors(count($data)),
                    'borderColor' => 'transparent',

                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
