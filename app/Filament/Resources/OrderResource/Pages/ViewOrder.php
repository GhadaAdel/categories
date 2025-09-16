<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
            // Actions\DeleteAction::make(),
            Actions\Action::make('Download Invoice')
                ->url(fn() => route('orders.invoice', $this->record->id))
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->openUrlInNewTab()
                ->tooltip('Download Invoice'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Order Summary')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Customer'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'completed' => 'success',
                                'pending' => 'warning',
                                'cancelled' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('total_price')
                            ->label('Total Price')
                            ->money('egp'),
                    ])
                    ->columns(3),

                Section::make('Order Details')
                    ->schema([
                        TextEntry::make('payment_method')
                            ->label('Payment Method'),
                        TextEntry::make('placed_at')
                            ->label('Placed At')
                            ->dateTime(),
                        TextEntry::make('shipped_at')
                            ->label('Shipped At')
                            ->dateTime(),
                    ])
                    ->columns(3),

                Section::make('Addresses')
                    ->schema([
                        TextEntry::make('shipping_address')
                            ->label('Shipping Address'),
                        TextEntry::make('billing_address')
                            ->label('Billing Address'),
                    ])
                    ->columns(2),
            ]);
    }
}
