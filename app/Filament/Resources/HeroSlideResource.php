<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages\CreateHeroSlide;
use App\Filament\Resources\HeroSlideResource\Pages\EditHeroSlide;
use App\Filament\Resources\HeroSlideResource\Pages\ListHeroSlides;
use App\Filament\Support\ManagedImageUpload;
use App\Filament\Support\ResourceTable;
use App\Models\HeroSlide;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use App\Filament\Tables\Columns\MediaImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Home Slides';

    protected static string | \UnitEnum | null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Slide content')
                ->description('Leave text fields empty for an image-only banner. Only filled fields appear on the website.')
                ->schema([
                    TextInput::make('title')->maxLength(255)
                        ->placeholder('Optional — leave empty to hide title'),
                    TextInput::make('subtitle')->maxLength(255)
                        ->placeholder('Optional'),
                    TextInput::make('button_text')->maxLength(100)
                        ->placeholder('Optional — e.g. Admission Open'),
                    TextInput::make('button_url')->url()->maxLength(255)
                        ->placeholder('Optional — leave empty to use admission form when button text is set'),
                    TextInput::make('sort_order')->numeric()->default(0)->helperText('Lower number shows first.'),
                    Toggle::make('is_published')->default(true),
                ])
                ->columns(2),
            Section::make('Banner photo')
                ->description('Wide photo (16:9). Crop to show the top of people/buildings if needed.')
                ->schema([
                    ...ManagedImageUpload::fields('image_path', 'hero', 'slides', required: true, label: 'Banner image'),
                ])
                ->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ResourceTable::editable($table, static::class, reorderable: true)
            ->columns([
                MediaImageColumn::make('image_path'),
                TextColumn::make('title')->searchable()->placeholder('Image only'),
                TextColumn::make('sort_order')->sortable(),
                ToggleColumn::make('is_published'),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHeroSlides::route('/'),
            'create' => CreateHeroSlide::route('/create'),
            'edit' => EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
