<?php

namespace App\Filament\Widgets;

use App\Models\DeskMessage;
use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\Video;
use Filament\Widgets\Widget;

class ContentChecklistWidget extends Widget
{
    protected static ?int $sort = -2;

    protected static bool $isDiscovered = true;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Content checklist';

    protected string $view = 'filament.widgets.content-checklist';

    protected function getViewData(): array
    {
        $settings = SiteSetting::query()->first();

        return [
            'items' => [
                $this->item(
                    'Logo uploaded',
                    $settings?->logo_path && ! str_contains((string) $settings->logo_path, 'demo/logo.svg')
                ),
                $this->item(
                    'Contact details (phone & email)',
                    filled($settings?->phone) && filled($settings?->email)
                        && ! str_contains((string) $settings->phone, '98765')
                ),
                $this->item(
                    'Real hero slides',
                    HeroSlide::query()->published()->where('image_path', 'not like', '%demo/hero-%')->exists()
                        || HeroSlide::query()->published()->where('image_path', 'like', 'slides/%')->exists()
                ),
                $this->item(
                    'News posts',
                    Post::query()->publishedPosts()->count() >= 1
                ),
                $this->item(
                    'Principal / Chairman photos',
                    DeskMessage::query()->published()->where(function ($q) {
                        $q->where('photo_path', 'like', 'desk/%')
                            ->orWhere('photo_path', 'like', 'settings/%');
                    })->exists()
                ),
                $this->item(
                    'Facility photos uploaded',
                    Facility::query()->published()->where('image_path', 'like', 'facilities/%')->exists()
                ),
                $this->item(
                    'Gallery photos',
                    GalleryItem::query()->published()->where('image_path', 'like', 'gallery/%')->exists()
                ),
                $this->item(
                    'YouTube videos',
                    Video::query()->published()->count() >= 1
                ),
                $this->item(
                    'Social links (optional)',
                    filled($settings?->facebook_url) || filled($settings?->instagram_url) || filled($settings?->youtube_channel_url)
                ),
            ],
        ];
    }

    private function item(string $label, bool $done): array
    {
        return ['label' => $label, 'done' => $done];
    }
}
