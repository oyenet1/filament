<?php

namespace App\Filament\Superadmin\Widgets;

use App\Models\School;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static bool $isScopedToTenant = false;
    // protected int|string|array $columnSpan = "full";
    protected function getStats(): array
    {
        $activeSchoolChart = activeSchoolChart();
        $schoolChart = schoolChart();
        $total = [$schoolChart[count($schoolChart) - 2], $schoolChart[count($schoolChart) - 1]];
        $active = [$activeSchoolChart[count($activeSchoolChart) - 2], $activeSchoolChart[count($activeSchoolChart) - 1]];
        return [
            Stat::make('Total Schools', formatNumber(array_sum($schoolChart)))
                ->description(getPercent($schoolChart[count($schoolChart) - 2], $schoolChart[count($schoolChart) - 1]) . ' since last year')
                ->descriptionIcon(getDirectionIcon(...$total))
                ->color($total[0] <= $total[1] ? 'success' : 'danger')
                ->chart($schoolChart),
            Stat::make('Active Schools', formatNumber(array_sum($activeSchoolChart)))
                ->description(getPercent($activeSchoolChart[count($activeSchoolChart) - 2], $activeSchoolChart[count($activeSchoolChart) - 1]) . ' since last year')
                ->descriptionIcon(getDirectionIcon(...$active))
                ->color($active[0] <= $active[1] ? 'success' : 'danger')
                ->chart($schoolChart)
        ];
    }
}
