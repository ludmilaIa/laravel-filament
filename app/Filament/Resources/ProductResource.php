<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'E-commerce';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->columnSpanFull(),
                TextArea::make('description')->columnSpanFull(),
                FileUpload::make('image')->columnSpanFull(),
                TextInput::make('price')->numeric()->columnSpanFull(),
                Select::make('currency_id')->relationship('currency','name')->columnSpanFull(),
                Select::make('provider_id')->relationship('provider','name')->columnSpanFull(),
                Select::make('status_id')->relationship('status','name')->columnSpanFull(),
                TextInput::make('stock')->numeric()->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('description')->searchable()->sortable(),
                ImageColumn::make('image')->circular(),
                TextColumn::make('price')->searchable()->sortable()->suffix('€')->toggleable(),
                TextColumn::make('currency.name')->toggleable(),
                TextColumn::make('stock')->searchable()->sortable()->toggleable(),
                TextColumn::make('provider.name')->toggleable()->sortable(),
                TextColumn::make('status.name')->toggleable()->sortable(),
                TextColumn::make('created_at')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true)->dateTime(),
                TextColumn::make('updated_at')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true)->dateTime(),
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
