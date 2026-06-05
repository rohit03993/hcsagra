<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Concerns\PreservesFileUploadsOnSave;
use App\Filament\Resources\SiteSettingResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditSiteSetting extends EditRecord
{
    use PreservesFileUploadsOnSave;

    protected static string $resource = SiteSettingResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Site settings';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Logo, contact, homepage text, and links — all in one place.';
    }

    protected function preservedUploadFields(): array
    {
        return ['logo_path', 'favicon_path'];
    }
}
