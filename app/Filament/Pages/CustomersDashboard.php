<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Dashboard;
use Filament\Forms\Components\Section;
use App\Filament\Clusters\MainDashboard;
use App\Filament\Widgets\CustomersChart;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class CustomersDashboard extends Dashboard
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $title = 'Customers Dashboard';
    protected static ?string $navigationLabel = 'Customers';
    protected static ?string $cluster = MainDashboard::class;
    protected static string $routePath = '/customers-dashboard';

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    DatePicker::make('start_date')
                        ->label('Start Date')
                        ->placeholder('Select date range')
                        ->displayFormat('Y-m-d')
                        ->required(),

                    DatePicker::make('end_date')
                        ->label('End Date')
                        ->placeholder('Select date range')
                        ->displayFormat('Y-m-d')
                        ->required(),
                ])->columns(2)
            ]);
    }

    public function getWidgets(): array
    {
        return [
            CustomersChart::class,
        ];
    }
}
