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
use App\Support\HomepageLimits;

class HomeController extends Controller
{
    public function __invoke()
    {
        $settings = SiteSetting::current();
        $showNews = $settings->showsNewsSection();
        $facilitiesLimit = $settings->homepageFacilitiesLimit();

        $publishedFacilities = Facility::query()->published()->ordered();
        $publishedGallery = GalleryItem::query()->published()->withImage()->ordered();
        $publishedTestimonials = Testimonial::query()->published()->ordered();
        $publishedVideos = Video::query()->published()->ordered();
        $publishedDeskMessages = DeskMessage::query()->published()->orderedForDisplay();

        $postCounts = $showNews
            ? Post::query()
                ->publishedPosts()
                ->selectRaw('type, count(*) as total')
                ->groupBy('type')
                ->pluck('total', 'type')
            : collect();

        return view('home', [
            'slides' => HeroSlide::query()->published()->withImage()->ordered()->get(),
            'announcements' => $showNews ? $this->posts(PostType::Announcement) : collect(),
            'achievements' => $showNews ? $this->posts(PostType::Achievement) : collect(),
            'events' => $showNews ? $this->posts(PostType::Event) : collect(),
            'hasMoreAnnouncements' => (int) ($postCounts[PostType::Announcement->value] ?? 0) > HomepageLimits::NEWS,
            'hasMoreAchievements' => (int) ($postCounts[PostType::Achievement->value] ?? 0) > HomepageLimits::NEWS,
            'hasMoreEvents' => (int) ($postCounts[PostType::Event->value] ?? 0) > HomepageLimits::NEWS,
            'facilities' => (clone $publishedFacilities)->limit($facilitiesLimit)->get(),
            'hasMoreFacilities' => $publishedFacilities->count() > $facilitiesLimit,
            'gallery' => (clone $publishedGallery)->limit(HomepageLimits::GALLERY)->get(),
            'hasMoreGallery' => $publishedGallery->count() > HomepageLimits::GALLERY,
            'testimonials' => (clone $publishedTestimonials)->limit(HomepageLimits::TESTIMONIALS)->get(),
            'hasMoreTestimonials' => $publishedTestimonials->count() > HomepageLimits::TESTIMONIALS,
            'videos' => (clone $publishedVideos)->limit(HomepageLimits::VIDEOS)->get(),
            'hasMoreVideos' => $publishedVideos->count() > HomepageLimits::VIDEOS,
            'deskMessages' => (clone $publishedDeskMessages)->limit(HomepageLimits::DESK_MESSAGES)->get(),
            'hasMoreDeskMessages' => $publishedDeskMessages->count() > HomepageLimits::DESK_MESSAGES,
        ]);
    }

    private function posts(PostType $type)
    {
        return Post::query()
            ->publishedPosts()
            ->ofType($type)
            ->orderByDesc('published_at')
            ->limit(HomepageLimits::NEWS)
            ->get();
    }
}
