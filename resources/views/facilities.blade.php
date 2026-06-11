@extends('layouts.app')

@section('seo')
    <x-seo title="School Facilities" :description="'Campus facilities — ' . $settings->school_name" />
@endsection

@section('content')
    <div class="site-container py-8 lg:py-12">
        <x-home-section-title section="facilities" />
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
            @forelse ($facilities as $facility)
                <div class="home-facility-card">
                    @if ($facility->image_path)
                        <div class="home-facility-card__media">
                            <img src="{{ \App\Support\MediaUrl::public($facility->image_path) }}" alt="{{ $facility->name }}" loading="lazy" width="320" height="200">
                        </div>
                    @else
                        <div class="home-facility-card__media home-facility-card__media--placeholder" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    @endif
                    <p class="home-facility-card__title">{{ $facility->name }}</p>
                </div>
            @empty
                <p class="col-span-full text-neutral-500 text-sm py-8 text-center">No facilities yet. Add them in admin → Facilities.</p>
            @endforelse
        </div>
    </div>
@endsection
