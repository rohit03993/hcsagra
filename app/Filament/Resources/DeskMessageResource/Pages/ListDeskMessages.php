<?php

namespace App\Filament\Resources\DeskMessageResource\Pages;

use App\Filament\Resources\DeskMessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeskMessages extends ListRecords
{
    protected static string $resource = DeskMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
