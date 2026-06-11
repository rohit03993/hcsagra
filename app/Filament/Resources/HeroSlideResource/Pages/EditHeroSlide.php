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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = parent::mutateFormDataBeforeSave($data);

        if (blank($data['image_path'] ?? null)) {
            $data['is_published'] = false;
        }

        return $data;
    }
}
