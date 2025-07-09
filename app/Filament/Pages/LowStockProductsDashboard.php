<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard;
use App\Filament\Clusters\MainDashboard;
use App\Filament\Widgets\LowStockProductsChart;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class LowStockProductsDashboard extends Dashboard
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $title = 'Low Stock Products Dashboard';
    protected static ?string $navigationLabel = 'Low Stock Products';
    protected static ?string $cluster = MainDashboard::class;
    protected static string $routePath = '/low-stock-products-dashboard';

    public function getWidgets(): array
    {
        return [
            LowStockProductsChart::class,
        ];
    }
}
