<?php

namespace App\Providers;

use App\Models\DeskMessage;
use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Support\ImageProcessor;
use App\Support\SiteNavigation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** @var array<class-string<Model>, array<string, string>> */
    private const IMAGE_FIELDS = [
        HeroSlide::class => ['image_path' => 'hero'],
        GalleryItem::class => ['image_path' => 'gallery'],
        Facility::class => ['image_path' => 'facility'],
        Post::class => ['image_path' => 'post'],
        DeskMessage::class => ['photo_path' => 'desk'],
        Page::class => ['hero_image_path' => 'page_hero'],
        SiteSetting::class => [
            'logo_path' => 'logo',
            'favicon_path' => 'favicon',
        ],
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        foreach (['slides', 'gallery', 'facilities', 'posts', 'messages', 'pages', 'settings'] as $dir) {
            Storage::disk('public')->makeDirectory($dir);
        }

        foreach (self::IMAGE_FIELDS as $modelClass => $fields) {
            $modelClass::saved(function (Model $record) use ($fields): void {
                $updates = [];

                foreach ($fields as $field => $preset) {
                    $path = ImageProcessor::normalizePath($record->{$field});
                    if ($path === null) {
                        continue;
                    }

                    $processed = ImageProcessor::process($path, $preset);
                    if ($processed !== null && $processed !== $path) {
                        $updates[$field] = $processed;
                    }
                }

                if ($updates !== []) {
                    $record->updateQuietly($updates);
                }
            });
        }

        View::composer('*', function ($view) {
            if (! request()->is('admin', 'admin/*')) {
                $view->with('settings', SiteSetting::current());
                $view->with('mainMenu', SiteNavigation::menu());
                $view->with('footerColumns', SiteNavigation::footerColumns());
            }
        });
    }
}
