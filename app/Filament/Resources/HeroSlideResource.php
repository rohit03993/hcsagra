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
                ->description('Each row here is one rotating banner on the homepage — add multiple slides, do not replace another slide’s image.')
                ->schema([
                    TextInput::make('title')->required()->maxLength(255),
                    TextInput::make('subtitle')->maxLength(255),
                    TextInput::make('button_text')->maxLength(100)->placeholder('Admission Open'),
                    TextInput::make('button_url')->url()->maxLength(255)
                        ->placeholder('Leave empty to use admission enquiry form'),
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
                TextColumn::make('title')->searchable(),
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
