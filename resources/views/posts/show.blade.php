@extends('layouts.app')

@section('seo')
    <x-seo
        :title="$post->meta_title ?: $post->title"
        :description="$post->meta_description ?: $post->excerpt"
        :image="$post->image_path"
    />
@endsection

@section('content')
    <article class="px-4 md:px-8 lg:px-10 py-6 md:py-10 max-w-3xl mx-auto">
        <p class="text-xs text-brand-600 font-bold uppercase tracking-wide">{{ $post->type->label() }}</p>
        <h1 class="text-2xl font-bold text-brand-900 mt-1">{{ $post->title }}</h1>
        @if ($post->published_at)
            <p class="text-sm text-slate-500 mt-1">{{ $post->published_at->format('d F Y') }}</p>
        @endif

        @if ($post->pdf_path)
            <a href="{{ \App\Support\MediaUrl::public($post->pdf_path) }}" target="_blank" rel="noopener"
               class="mt-6 flex items-center gap-4 rounded-2xl bg-red-50 border-2 border-red-200 p-4 hover:bg-red-100 transition">
                <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-red-600 text-white font-bold">PDF</span>
                <span class="flex-1">
                    <span class="font-bold text-red-900 block">Download circular (PDF)</span>
                    <span class="text-sm text-red-700">Opens in new tab — save or print</span>
                </span>
                <span class="font-bold text-red-800">Open →</span>
            </a>
        @endif

        @if ($post->image_path)
            <img src="{{ \App\Support\MediaUrl::public($post->image_path) }}" alt="" class="w-full rounded-2xl mt-6" loading="lazy" decoding="async">
        @endif

        <div class="prose prose-sm md:prose-base prose-slate max-w-none mt-6">
            {!! $post->body !!}
        </div>

        @if ($post->external_url)
            <a href="{{ $post->external_url }}" class="inline-block mt-6 text-brand-700 font-semibold text-sm" target="_blank" rel="noopener">External link →</a>
        @endif

        <a href="{{ route('posts.index', ['type' => $post->type->value]) }}" class="block mt-10 text-sm text-slate-500 hover:text-brand-700">← Back to {{ $post->type->label() }}</a>
    </article>
@endsection
