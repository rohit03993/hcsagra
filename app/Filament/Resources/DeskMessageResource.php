<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeskMessageResource\Pages\CreateDeskMessage;
use App\Filament\Resources\DeskMessageResource\Pages\EditDeskMessage;
use App\Filament\Resources\DeskMessageResource\Pages\ListDeskMessages;
use App\Filament\Support\ManagedImageUpload;
use App\Filament\Support\ResourceTable;
use App\Filament\Tables\Columns\MediaImageColumn;
use App\Models\DeskMessage;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class DeskMessageResource extends Resource
{
    protected static ?string $model = DeskMessage::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $navigationLabel = 'Desk Messages';

    protected static string | \UnitEnum | null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('role')->options([
                'principal' => 'Principal',
                'chairman' => 'Chairman',
            ])->required()->native(false),
            TextInput::make('name')->required(),
            TextInput::make('designation'),
            ...ManagedImageUpload::fields('photo_path', 'desk', 'messages', label: 'Upload or edit photo'),
            Textarea::make('message')->required()->rows(6)->columnSpanFull(),
            TextInput::make('sort_order')->numeric()->default(0),
            Toggle::make('is_published')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ResourceTable::editable($table, static::class, reorderable: true)
            ->columns([
                MediaImageColumn::make('photo_path')->label('Photo'),
                TextColumn::make('role')->badge(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('sort_order')->sortable(),
                ToggleColumn::make('is_published'),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeskMessages::route('/'),
            'create' => CreateDeskMessage::route('/create'),
            'edit' => EditDeskMessage::route('/{record}/edit'),
        ];
    }
}
