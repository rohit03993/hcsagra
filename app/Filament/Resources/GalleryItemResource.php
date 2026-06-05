<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryItemResource\Pages\CreateGalleryItem;
use App\Filament\Resources\GalleryItemResource\Pages\EditGalleryItem;
use App\Filament\Resources\GalleryItemResource\Pages\ListGalleryItems;
use App\Filament\Support\ManagedImageUpload;
use App\Filament\Support\ResourceTable;
use App\Models\GalleryItem;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use App\Filament\Tables\Columns\MediaImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static ?string $navigationLabel = 'Gallery';

    protected static string | \UnitEnum | null $navigationGroup = 'Website content';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title'),
            TextInput::make('album')->placeholder('e.g. Annual Day 2025'),
            ...ManagedImageUpload::fields('image_path', 'gallery', 'gallery', required: true, label: 'Gallery image'),
            TextInput::make('sort_order')->numeric()->default(0),
            Toggle::make('is_published')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ResourceTable::editable($table, static::class, reorderable: true)
            ->columns([
                MediaImageColumn::make('image_path'),
                TextColumn::make('title')->searchable(),
                TextColumn::make('album'),
                ToggleColumn::make('is_published'),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGalleryItems::route('/'),
            'create' => CreateGalleryItem::route('/create'),
            'edit' => EditGalleryItem::route('/{record}/edit'),
        ];
    }
}
