<?php

namespace App\Filament\Support;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ResourceTable
{
    /**
     * Click row or use Edit / Delete — standard for content resources.
     *
     * @param  class-string<Resource>  $resourceClass
     */
    public static function editable(
        Table $table,
        string $resourceClass,
        bool $reorderable = false,
        ?string $reorderColumn = 'sort_order',
    ): Table {
        $table = $table
            ->recordUrl(fn (Model $record): string => $resourceClass::getUrl('edit', ['record' => $record]))
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->striped()
            ->defaultPaginationPageOption(25);

        if ($reorderable && $reorderColumn) {
            $table->reorderable($reorderColumn);
        }

        return $table;
    }

    /**
     * @param  class-string<Resource>  $resourceClass
     */
    public static function inbox(Table $table, string $resourceClass): Table
    {
        return $table
            ->recordUrl(fn (Model $record): string => $resourceClass::getUrl('view', ['record' => $record]))
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->striped()
            ->defaultPaginationPageOption(25);
    }
}
