<?php

namespace App\Filament\Resources;

use App\Filament\Support\ResourceTable;
use App\Filament\Resources\AdmissionEnquiryResource\Pages\ListAdmissionEnquiries;
use App\Filament\Resources\AdmissionEnquiryResource\Pages\ViewAdmissionEnquiry;
use App\Models\AdmissionEnquiry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AdmissionEnquiryResource extends Resource
{
    protected static ?string $model = AdmissionEnquiry::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static ?string $navigationLabel = 'Admission Enquiries';

    protected static string | \UnitEnum | null $navigationGroup = 'Inbox';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = AdmissionEnquiry::query()->whereNull('read_at')->count();

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
            TextEntry::make('student_name'),
            TextEntry::make('parent_name'),
            TextEntry::make('phone'),
            TextEntry::make('email')->placeholder('—'),
            TextEntry::make('class_applying')->label('Class'),
            TextEntry::make('message')->placeholder('—')->columnSpanFull(),
            TextEntry::make('created_at')->dateTime(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ResourceTable::inbox($table, static::class)
            ->columns([
                TextColumn::make('student_name')->searchable()->sortable(),
                TextColumn::make('parent_name')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('class_applying')->label('Class'),
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
            'index' => ListAdmissionEnquiries::route('/'),
            'view' => ViewAdmissionEnquiry::route('/{record}'),
        ];
    }
}
