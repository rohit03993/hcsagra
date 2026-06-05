<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages\CreateVideo;
use App\Filament\Resources\VideoResource\Pages\EditVideo;
use App\Filament\Resources\VideoResource\Pages\ListVideos;
use App\Filament\Support\ResourceTable;
use App\Filament\Tables\Columns\YoutubeThumbnailColumn;
use App\Models\Video;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    protected static ?string $navigationLabel = 'Videos';

    protected static string | \UnitEnum | null $navigationGroup = 'Website content';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required(),
            TextInput::make('youtube_url')->label('YouTube URL')->url()->required()
                ->placeholder('https://www.youtube.com/watch?v=...')
                ->helperText('Paste a school video link. The site shows a thumbnail; clicking plays the video on your page.'),
            TextInput::make('sort_order')->numeric()->default(0),
            Toggle::make('is_published')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ResourceTable::editable($table, static::class, reorderable: true)
            ->columns([
                YoutubeThumbnailColumn::make('youtube_id')->label('Preview'),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('youtube_id')->label('Video ID')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sort_order')->sortable(),
                ToggleColumn::make('is_published'),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVideos::route('/'),
            'create' => CreateVideo::route('/create'),
            'edit' => EditVideo::route('/{record}/edit'),
        ];
    }
}
