<?php

namespace App\Filament\Resources;

use App\Filament\Support\ResourceTable;
use App\Filament\Resources\ContactMessageResource\Pages\ListContactMessages;
use App\Filament\Resources\ContactMessageResource\Pages\ViewContactMessage;
use App\Models\ContactMessage;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $navigationLabel = 'Contact Messages';

    protected static string | \UnitEnum | null $navigationGroup = 'Inbox';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $count = ContactMessage::query()->whereNull('read_at')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('name'),
            TextEntry::make('phone'),
            TextEntry::make('email')->placeholder('—'),
            TextEntry::make('message')->columnSpanFull(),
            TextEntry::make('created_at')->dateTime(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ResourceTable::inbox($table, static::class)
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('phone'),
                TextColumn::make('email')->placeholder('—')->toggleable(),
                TextColumn::make('message')->limit(40)->toggleable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('read_at')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => filled($state) ? 'Read' : 'New')
                    ->badge()
                    ->color(fn ($state) => filled($state) ? 'gray' : 'warning'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('unread')->query(fn (Builder $q) => $q->whereNull('read_at'))->label('Unread only'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactMessages::route('/'),
            'view' => ViewContactMessage::route('/{record}'),
        ];
    }
}
