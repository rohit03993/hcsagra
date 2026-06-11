<?php

namespace App\Http\Controllers;

use App\Models\DeskMessage;
use App\Models\DisclosureDocument;
use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\Page;
use App\Models\Testimonial;
use App\Models\Video;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::query()->published()->where('slug', $slug)->firstOrFail();

        return view('pages.show', compact('page'));
    }

    public function gallery(): View
    {
        $items = GalleryItem::query()->published()->withImage()->ordered()->paginate(24);

        return view('gallery', compact('items'));
    }

    public function contact(): View
    {
        return view('contact');
    }

    public function videos(): View
    {
        $videos = Video::query()->published()->ordered()->paginate(12);

        return view('videos', compact('videos'));
    }

    public function facilities(): View
    {
        $facilities = Facility::query()->published()->ordered()->get();

        return view('facilities', compact('facilities'));
    }

    public function testimonials(): View
    {
        $testimonials = Testimonial::query()->published()->ordered()->paginate(12);

        return view('testimonials', compact('testimonials'));
    }

    public function leadership(): View
    {
        $messages = DeskMessage::query()->published()->orderedForDisplay()->get();

        return view('leadership', compact('messages'));
    }

    public function mandatoryDisclosure(): View
    {
        $documents = DisclosureDocument::query()->published()->ordered()->get();
        $page = Page::query()->published()->where('slug', 'mandatory-disclosure')->first();

        return view('mandatory-disclosure', compact('documents', 'page'));
    }
}
