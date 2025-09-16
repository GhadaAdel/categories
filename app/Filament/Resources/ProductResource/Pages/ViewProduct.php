<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use App\Filament\Resources\ProductResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([

            Section::make('Product Info')
                ->schema([
                    TextEntry::make('name')
                        ->label('Product Name'),
                    TextEntry::make('slug')
                        ->label('Slug'),
                    TextEntry::make('type')
                        ->label('Product Type')->badge(),
                    TextEntry::make('price')
                        ->label('Price')
                        ->money('egp'),
                    TextEntry::make('stock')
                        ->label('Stock'),
                    TextEntry::make('is_published')
                        ->label('Published'),
                ])
                ->columns(3),

            Section::make('Category')
                ->schema([
                    TextEntry::make('category.name')
                        ->label('Category'),
                ])
                ->columns(1),

            Section::make('Description')
                ->schema([
                    TextEntry::make('description')
                        ->label('Product Description'),
                ])
                ->columns(1),

            Section::make('Product Images')
                ->schema([
                    RepeatableEntry::make('images')
                        ->label(false)
                        ->schema([
                            ImageEntry::make('image_path')
                                ->label(false)
                                ->height(150)
                                ->extraImgAttributes(['style' => 'object-fit: cover; width: 100%; height: 100%;']), // Keeps images neat
                        ])
                        ->grid(3)
                        ->columnSpanFull()
                        ->label('Images'),
                ])
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}