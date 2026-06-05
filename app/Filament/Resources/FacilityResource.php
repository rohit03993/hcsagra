<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilityResource\Pages\CreateFacility;
use App\Filament\Resources\FacilityResource\Pages\EditFacility;
use App\Filament\Resources\FacilityResource\Pages\ListFacilities;
use App\Filament\Support\ManagedImageUpload;
use App\Filament\Support\ResourceTable;
use App\Models\Facility;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use App\Filament\Tables\Columns\MediaImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?string $navigationLabel = 'Facilities';

    protected static string | \UnitEnum | null $navigationGroup = 'Website content';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            ...ManagedImageUpload::fields('image_path', 'facility', 'facilities', label: 'Facility image'),
            Textarea::make('description')->rows(3),
            TextInput::make('sort_order')->numeric()->default(0),
            Toggle::make('is_published')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ResourceTable::editable($table, static::class, reorderable: true)
            ->columns([
                MediaImageColumn::make('image_path'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('sort_order')->sortable(),
                ToggleColumn::make('is_published'),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFacilities::route('/'),
            'create' => CreateFacility::route('/create'),
            'edit' => EditFacility::route('/{record}/edit'),
        ];
    }
}
