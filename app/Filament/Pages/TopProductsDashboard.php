<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard;
use App\Filament\Clusters\MainDashboard;
use App\Filament\Widgets\TopProductsChart;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class TopProductsDashboard extends Dashboard
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $title = 'Top Products Dashboard';
    protected static ?string $navigationLabel = 'Top Products';
    protected static ?string $cluster = MainDashboard::class;
    protected static string $routePath = '/top-products-dashboard';

    public function getWidgets(): array
    {
        return [
            TopProductsChart::class,
        ];
    }
}
