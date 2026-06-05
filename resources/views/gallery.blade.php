@extends('layouts.app')

@section('seo')
    <x-seo title="Photo Gallery" :description="'Event photos and campus gallery — ' . $settings->school_name" />
@endsection

@section('content')
    <div class="site-container py-8 lg:py-12">
        <x-section-title subtitle="Campus life">Photo Gallery</x-section-title>
        <p class="text-sm text-neutral-500 -mt-3 mb-6">Tap any photo to view full size.</p>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 lg:gap-4" data-gallery-grid>
            @forelse ($items as $item)
                @php
                    $src = \App\Support\MediaUrl::public($item->image_path);
                    $title = $item->title ?? 'Photo';
                @endphp
                <figure class="rounded-xl overflow-hidden bg-white shadow-sm border border-neutral-200">
                    <x-gallery-thumb :src="$src" :caption="$title" class="rounded-xl">
                        <img
                            src="{{ $src }}"
                            alt="{{ $title }}"
                            class="w-full aspect-square object-cover group-hover:scale-105 transition duration-300"
                            loading="lazy"
                            decoding="async"
                            width="300"
                            height="300"
                        >
                    </x-gallery-thumb>
                    @if ($item->title)
                        <figcaption class="text-xs p-2.5 text-center text-neutral-600 font-medium">{{ $item->title }}</figcaption>
                    @endif
                </figure>
            @empty
                <p class="col-span-full text-neutral-500 text-sm py-8 text-center">No gallery photos yet. Add them in admin → Gallery.</p>
            @endforelse
        </div>

        @if ($items->hasPages())
            <div class="mt-8">{{ $items->links() }}</div>
        @endif
    </div>
@endsection
