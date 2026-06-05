@extends('layouts.app')

@section('seo')
    <x-seo
        :title="$page->meta_title ?: $page->title"
        :description="$page->meta_description ?: strip_tags($page->body ?? '')"
        :image="$page->hero_image_path"
    />
@endsection

@section('content')
    <article class="px-4 md:px-8 lg:px-10 py-6 md:py-10 max-w-3xl mx-auto">
        @if ($page->hero_image_path)
            <img src="{{ \App\Support\MediaUrl::public($page->hero_image_path) }}" alt="" class="w-full rounded-2xl mb-6 aspect-[2/1] object-cover" loading="lazy" decoding="async">
        @endif
        <h1 class="text-2xl font-bold text-brand-900">{{ $page->title }}</h1>
        <div class="prose prose-sm md:prose-base prose-slate max-w-none mt-6">
            {!! $page->body !!}
        </div>
    </article>
@endsection
