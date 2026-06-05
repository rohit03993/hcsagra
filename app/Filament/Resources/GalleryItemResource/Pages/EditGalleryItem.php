<?php

namespace App\Filament\Resources\GalleryItemResource\Pages;

use App\Filament\Concerns\PreservesFileUploadsOnSave;
use App\Filament\Resources\GalleryItemResource;
use Filament\Resources\Pages\EditRecord;

class EditGalleryItem extends EditRecord
{
    use PreservesFileUploadsOnSave;

    protected static string $resource = GalleryItemResource::class;

    protected function preservedUploadFields(): array
    {
        return ['image_path'];
    }
}
