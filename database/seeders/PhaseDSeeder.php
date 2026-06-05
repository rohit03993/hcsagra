<?php

namespace Database\Seeders;

use App\Models\DeskMessage;
use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\Video;
use Illuminate\Database\Seeder;

/**
 * Replaces external demo URLs with local placeholders and removes joke YouTube demos.
 * Safe to run multiple times.
 */
class PhaseDSeeder extends Seeder
{
    private const PLACEHOLDER_YOUTUBE_IDS = [
        'dQw4w9WgXcQ',
        '9bZkp7q19f0',
    ];

    public function run(): void
    {
        $this->swapHeroSlides();
        $this->unpublishPlaceholderVideos();
        $this->swapPicsumPaths();
        $this->ensureSiteSettingHints();

        SiteSetting::clearCache();

        $this->command?->info('Phase D: Demo placeholders updated. See CONTENT.md for your real photos and text.');
    }

    private function swapHeroSlides(): void
    {
        $local = [
            'images/demo/hero-1.svg',
            'images/demo/hero-2.svg',
            'images/demo/hero-3.svg',
        ];

        HeroSlide::query()
            ->orderBy('sort_order')
            ->get()
            ->each(function (HeroSlide $slide, int $i) use ($local) {
                if ($this->isExternalUrl($slide->image_path)) {
                    $slide->update(['image_path' => $local[$i % count($local)]]);
                }
            });

        if (HeroSlide::query()->count() === 0) {
            return;
        }
    }

    private function unpublishPlaceholderVideos(): void
    {
        Video::query()
            ->whereIn('youtube_id', self::PLACEHOLDER_YOUTUBE_IDS)
            ->delete();
    }

    private function swapPicsumPaths(): void
    {
        $placeholder = 'images/demo/placeholder.svg';

        Post::query()
            ->where('image_path', 'like', '%picsum.photos%')
            ->update(['image_path' => $placeholder]);

        Facility::query()
            ->where('image_path', 'like', '%picsum.photos%')
            ->update(['image_path' => $placeholder]);

        GalleryItem::query()
            ->where('image_path', 'like', '%picsum.photos%')
            ->update(['image_path' => $placeholder]);

        DeskMessage::query()
            ->where('photo_path', 'like', '%picsum.photos%')
            ->get()
            ->each(fn (DeskMessage $msg) => $msg->update(['photo_path' => $placeholder]));
    }

    private function ensureSiteSettingHints(): void
    {
        $setting = SiteSetting::query()->first();
        if (! $setting) {
            return;
        }

        $updates = [];

        if (in_array($setting->facebook_url, ['https://facebook.com', 'http://facebook.com'], true)) {
            $updates['facebook_url'] = null;
        }
        if (in_array($setting->instagram_url, ['https://instagram.com', 'http://instagram.com'], true)) {
            $updates['instagram_url'] = null;
        }
        if (in_array($setting->youtube_channel_url, ['https://youtube.com', 'http://youtube.com'], true)) {
            $updates['youtube_channel_url'] = null;
        }

        if ($updates !== []) {
            $setting->update($updates);
        }
    }

    private function isExternalUrl(?string $path): bool
    {
        return $path && (str_starts_with($path, 'http://') || str_starts_with($path, 'https://'));
    }
}
