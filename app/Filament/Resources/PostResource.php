<?php

namespace App\Filament\Resources;

use App\Enums\PostType;
use App\Filament\Support\ManagedImageUpload;
use App\Filament\Support\ResourceTable;
use App\Filament\Tables\Columns\MediaImageColumn;
use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?string $navigationLabel = 'News & Posts';

    protected static string | \UnitEnum | null $navigationGroup = 'Website content';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('type')
                ->options(collect(PostType::cases())->mapWithKeys(fn (PostType $t) => [$t->value => $t->label()]))
                ->required()
                ->native(false),
            TextInput::make('title')->required()->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state ?? ''))),
            TextInput::make('slug')->required()->maxLength(255)->unique(ignoreRecord: true),
            Section::make('SEO')->schema([
                TextInput::make('meta_title')->maxLength(70)->helperText('Leave blank to use post title'),
                Textarea::make('meta_description')->rows(2)->maxLength(160)->helperText('Max ~160 characters for Google'),
            ])->collapsed(),
            Textarea::make('excerpt')->rows(2)->maxLength(500),
            RichEditor::make('body')->columnSpanFull(),
            ...ManagedImageUpload::fields('image_path', 'post', 'posts', label: 'Thumbnail image'),
            FileUpload::make('pdf_path')->label('PDF circular')->acceptedFileTypes(['application/pdf'])->disk('public')->directory('posts/pdf')->helperText('Upload official circular PDF'),
            TextInput::make('external_url')->url(),
            DateTimePicker::make('published_at'),
            Toggle::make('is_published')->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ResourceTable::editable($table, static::class)
            ->columns([
                MediaImageColumn::make('image_path')->label('Thumb'),
                TextColumn::make('type')->badge(),
                TextColumn::make('title')->searchable()->limit(40),
                TextColumn::make('published_at')->dateTime()->sortable(),
                ToggleColumn::make('is_published'),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                SelectFilter::make('type')->options(collect(PostType::cases())->mapWithKeys(fn (PostType $t) => [$t->value => $t->label()])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
