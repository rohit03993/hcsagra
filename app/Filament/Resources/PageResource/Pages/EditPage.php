<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Concerns\PreservesFileUploadsOnSave;
use App\Filament\Resources\PageResource;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    use PreservesFileUploadsOnSave;

    protected static string $resource = PageResource::class;

    protected function preservedUploadFields(): array
    {
        return ['hero_image_path'];
    }
}
