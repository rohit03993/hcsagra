<?php

namespace App\Http\Controllers;

use App\Enums\PostType;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless(SiteSetting::current()->showsNewsSection(), 404);

        $type = PostType::tryFrom($request->query('type', 'announcement')) ?? PostType::Announcement;

        $posts = Post::query()
            ->publishedPosts()
            ->ofType($type)
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('posts.index', compact('posts', 'type'));
    }

    public function show(string $slug): View
    {
        abort_unless(SiteSetting::current()->showsNewsSection(), 404);

        $post = Post::query()
            ->publishedPosts()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }
}
