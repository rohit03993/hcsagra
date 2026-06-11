<?php

namespace App\Http\Controllers;

use App\Enums\PostType;
use App\Models\DeskMessage;
use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\Video;

class HomeController extends Controller
{
    public function __invoke()
    {
        $settings = SiteSetting::current();
        $showNews = $settings->showsNewsSection();

        return view('home', [
            'slides' => HeroSlide::query()->published()->withImage()->ordered()->get(),
            'announcements' => $showNews ? $this->posts(PostType::Announcement, 3) : collect(),
            'achievements' => $showNews ? $this->posts(PostType::Achievement, 3) : collect(),
            'events' => $showNews ? $this->posts(PostType::Event, 3) : collect(),
            'facilities' => Facility::query()->published()->ordered()->limit(8)->get(),
            'gallery' => GalleryItem::query()->published()->withImage()->ordered()->limit(6)->get(),
            'videos' => Video::query()->published()->ordered()->limit(4)->get(),
            'deskMessages' => DeskMessage::query()->published()->orderedForDisplay()->get(),
            'testimonials' => Testimonial::query()->published()->ordered()->limit(5)->get(),
        ]);
    }

    private function posts(PostType $type, int $limit)
    {
        return Post::query()
            ->publishedPosts()
            ->ofType($type)
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get();
    }
}
