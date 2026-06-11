@extends('layouts.app')

@section('seo')
    <x-seo title="Leadership Messages" :description="'Messages from school leadership — ' . $settings->school_name" />
@endsection

@section('content')
    <div class="site-container py-8 lg:py-12">
        <x-home-section-title section="leadership" />
        <div class="grid gap-6 md:grid-cols-2 leadership-messages">
            @forelse ($messages as $message)
                <article class="home-desk-card">
                    <div class="home-desk-card__head">
                        @if ($message->photo_path)
                            <img src="{{ \App\Support\MediaUrl::public($message->photo_path) }}" alt="{{ $message->name }}" class="home-desk-card__photo" loading="lazy" width="80" height="80">
                        @else
                            <div class="home-desk-card__initial" aria-hidden="true">{{ substr($message->name, 0, 1) }}</div>
                        @endif
                        <div class="min-w-0">
                            <p class="home-desk-card__role">{{ $message->roleLabel() }}</p>
                            <h3 class="home-desk-card__name">{{ $message->name }}</h3>
                            @if ($message->designation)
                                <p class="home-desk-card__designation">{{ $message->designation }}</p>
                            @endif
                        </div>
                    </div>
                    <p class="home-desk-card__message">{{ $message->message }}</p>
                </article>
            @empty
                <p class="col-span-full text-neutral-500 text-sm py-8 text-center">No leadership messages yet.</p>
            @endforelse
        </div>
    </div>
@endsection
