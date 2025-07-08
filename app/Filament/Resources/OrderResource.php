<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Information')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Select::make('user_id')
                                ->label('User')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->required(),
                            TextInput::make('total_price')
                                ->numeric()
                                ->required(),
                            TextInput::make('shipping_address')
                                ->label('Shipping Address')
                                ->required(),
                            TextInput::make('billing_address')
                                ->label('Billing Address')
                                ->required(),
                        ]),
                    Step::make('Configurations')
                        ->icon('heroicon-o-cog-8-tooth')
                        ->schema([
                            DatePicker::make('placed_at'),
                            DatePicker::make('shipped_at'),
                            TextInput::make('payment_method')
                                ->label('Payment Method')
                                ->required(),
                        ]),
                ])->skippable()
            ])
            ->columns(1);    
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->badge()
                    ->color(fn ($record) => 'primary')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status'),
                TextColumn::make('total_price')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('placed_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('shipped_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
