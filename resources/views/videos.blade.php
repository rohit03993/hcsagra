@extends('layouts.app')

@section('seo')
    <x-seo title="School Videos" :description="'Campus tour and school videos — ' . $settings->school_name" />
@endsection

@section('content')
    <div class="site-container py-5 space-y-6">
        <h1 class="text-xl font-bold text-brand-900">School Videos</h1>
        @forelse ($videos as $video)
            <div>
                <h2 class="text-sm font-semibold mb-2">{{ $video->title }}</h2>
                <x-youtube-lite :video-id="$video->youtube_id" :title="$video->title" />
            </div>
        @empty
            <p class="text-slate-500 text-sm">No videos yet. Add YouTube links in admin.</p>
        @endforelse
        <div>{{ $videos->links() }}</div>
    </div>
@endsection
