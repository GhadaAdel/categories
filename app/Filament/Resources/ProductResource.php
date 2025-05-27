<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Filament\Clusters\Settings;
use App\Filament\Enums\Category;
use App\Filament\Enums\ProductType;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Forms\Components\Select;

class ProductResource extends Resource
{
    protected static ?string $cluster = Settings::class;

    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Products')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(60)
                            ->label('Product Name')
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->reactive(),
                        Forms\Components\TextInput::make('slug')
                            ->nullable()
                            ->unique(ignoreRecord: true)
                            ->disabled(),
                        Forms\Components\Textarea::make('description')
                            ->nullable(),
                        Forms\Components\TextInput::make('price')
                            ->required(),
                        FileUpload::make('image'),
                        Checkbox::make('is_published'),
                        Select::make('category_id')
                            ->label('Related Category')
                            ->required()
                            ->relationship('category', 'name'),
                        Select::make('type')
                            ->label('Product Type')
                            ->required()
                            ->options(
                                collect(ProductType::cases())->mapWithKeys(function ($case) {
                                    return [$case->value => $case->getLabel()];
                                })->toArray()
                            ),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price'),
                ImageColumn::make('image'),
                CheckboxColumn::make('is_published'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
