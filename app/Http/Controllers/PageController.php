<?php

namespace App\Http\Controllers;

use App\Models\DisclosureDocument;
use App\Models\GalleryItem;
use App\Models\Page;
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

    public function mandatoryDisclosure(): View
    {
        $documents = DisclosureDocument::query()->published()->ordered()->get();
        $page = Page::query()->published()->where('slug', 'mandatory-disclosure')->first();

        return view('mandatory-disclosure', compact('documents', 'page'));
    }
}
