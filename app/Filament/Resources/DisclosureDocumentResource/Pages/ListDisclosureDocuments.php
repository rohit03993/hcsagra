<?php

namespace App\Filament\Resources\DisclosureDocumentResource\Pages;

use App\Filament\Resources\DisclosureDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDisclosureDocuments extends ListRecords
{
    protected static string $resource = DisclosureDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
