<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('posts.index', ['type' => 'announcement']), 'priority' => '0.9'],
            ['loc' => route('gallery'), 'priority' => '0.8'],
            ['loc' => route('videos'), 'priority' => '0.8'],
            ['loc' => route('contact'), 'priority' => '0.8'],
            ['loc' => route('admission.enquiry'), 'priority' => '0.9'],
            ['loc' => route('mandatory-disclosure'), 'priority' => '0.6'],
        ];

        foreach (Page::query()->published()->get(['slug', 'updated_at']) as $page) {
            $urls[] = [
                'loc' => route('pages.show', $page->slug),
                'lastmod' => $page->updated_at?->toAtomString(),
                'priority' => '0.7',
            ];
        }

        foreach (Post::query()->publishedPosts()->get(['slug', 'updated_at']) as $post) {
            $urls[] = [
                'loc' => route('posts.show', $post->slug),
                'lastmod' => $post->updated_at?->toAtomString(),
                'priority' => '0.6',
            ];
        }

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
