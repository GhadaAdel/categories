<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
            // Actions\DeleteAction::make(),
            Actions\Action::make('Download Invoice')
                ->url(fn () => route('orders.invoice', $this->record->id))
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->openUrlInNewTab()
                ->tooltip('Download Invoice'),
        ];
    }
}