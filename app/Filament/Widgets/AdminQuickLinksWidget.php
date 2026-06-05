<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AdmissionEnquiryResource;
use App\Filament\Resources\DeskMessageResource;
use App\Filament\Resources\GalleryItemResource;
use App\Filament\Resources\HeroSlideResource;
use App\Filament\Resources\SiteSettingResource;
use App\Filament\Resources\VideoResource;
use App\Models\SiteSetting;
use Filament\Widgets\Widget;

class AdminQuickLinksWidget extends Widget
{
    protected static ?int $sort = -3;

    protected static bool $isDiscovered = true;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Quick edit';

    protected string $view = 'filament.widgets.admin-quick-links';

    protected function getViewData(): array
    {
        $settings = SiteSetting::query()->first();

        return [
            'links' => [
                [
                    'label' => 'Site settings',
                    'hint' => 'Logo, phone, social links',
                    'url' => $settings
                        ? SiteSettingResource::getUrl('edit', ['record' => $settings])
                        : SiteSettingResource::getUrl('index'),
                ],
                [
                    'label' => 'Home slides',
                    'hint' => 'Banner images on homepage',
                    'url' => HeroSlideResource::getUrl('index'),
                ],
                [
                    'label' => 'Principal / Chairman',
                    'hint' => 'Desk messages & photos',
                    'url' => DeskMessageResource::getUrl('index'),
                ],
                [
                    'label' => 'Gallery',
                    'hint' => 'Campus photos',
                    'url' => GalleryItemResource::getUrl('index'),
                ],
                [
                    'label' => 'Videos',
                    'hint' => 'YouTube campus videos',
                    'url' => VideoResource::getUrl('index'),
                ],
                [
                    'label' => 'Admission enquiries',
                    'hint' => 'New form submissions',
                    'url' => AdmissionEnquiryResource::getUrl('index'),
                ],
            ],
        ];
    }
}
