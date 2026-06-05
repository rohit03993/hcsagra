<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

    public function mount(): void
    {
        parent::mount();

        $settings = SiteSetting::query()->first();

        if ($settings !== null) {
            $this->redirect(SiteSettingResource::getUrl('edit', ['record' => $settings]));
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->visible(fn (): bool => SiteSetting::query()->count() === 0),
        ];
    }
}
