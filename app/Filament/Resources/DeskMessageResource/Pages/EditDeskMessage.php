<?php

namespace App\Filament\Resources\DeskMessageResource\Pages;

use App\Filament\Concerns\PreservesFileUploadsOnSave;
use App\Filament\Resources\DeskMessageResource;
use Filament\Resources\Pages\EditRecord;

class EditDeskMessage extends EditRecord
{
    use PreservesFileUploadsOnSave;

    protected static string $resource = DeskMessageResource::class;

    protected function preservedUploadFields(): array
    {
        return ['photo_path'];
    }
}
