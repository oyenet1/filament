<?php

namespace App\Filament\Superadmin\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SchoolPieChart extends ChartWidget
{
    protected static ?string $heading = 'School Status Overview';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = DB::table('schools')->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderBy('status')
            ->pluck('total', 'status')
            ->toArray();
        return [
            'datasets' => [
                [
                    'label' => 'Schools Based on Status',
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
        return 'doughnut';
    }

    // public function getDescription(): ?string
    // {
    //     return 'All Schools';
    // }
}
