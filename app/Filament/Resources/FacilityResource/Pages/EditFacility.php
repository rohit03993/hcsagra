<?php

namespace App\Filament\Resources\FacilityResource\Pages;

use App\Filament\Concerns\PreservesFileUploadsOnSave;
use App\Filament\Resources\FacilityResource;
use Filament\Resources\Pages\EditRecord;

class EditFacility extends EditRecord
{
    use PreservesFileUploadsOnSave;

    protected static string $resource = FacilityResource::class;

    protected function preservedUploadFields(): array
    {
        return ['image_path'];
    }
}
