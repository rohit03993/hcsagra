<?php

namespace App\Filament\Resources\HeroSlideResource\Pages;

use App\Filament\Concerns\PreservesFileUploadsOnSave;
use App\Filament\Resources\HeroSlideResource;
use Filament\Resources\Pages\EditRecord;

class EditHeroSlide extends EditRecord
{
    use PreservesFileUploadsOnSave;

    protected static string $resource = HeroSlideResource::class;

    protected function preservedUploadFields(): array
    {
        return ['image_path'];
    }
}
