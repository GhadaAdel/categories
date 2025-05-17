<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CategoriesStatsWidget extends BaseWidget
{
    protected function getColumns(): int
    {
        return 2;
    }
    
    protected function getStats(): array
    {
        return [
            Stat::make('Categories Count', Category::count()),
            Stat::make('Published Categories', Category::sum('is_published')),
        ];
    }
}
