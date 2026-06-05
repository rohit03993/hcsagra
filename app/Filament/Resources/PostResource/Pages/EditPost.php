<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Concerns\PreservesFileUploadsOnSave;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    use PreservesFileUploadsOnSave;

    protected static string $resource = PostResource::class;

    protected function preservedUploadFields(): array
    {
        return ['image_path', 'pdf_path'];
    }
}
