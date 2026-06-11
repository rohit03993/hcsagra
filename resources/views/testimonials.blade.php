@extends('layouts.app')

@section('seo')
    <x-seo title="Parent Testimonials" :description="'What parents say — ' . $settings->school_name" />
@endsection

@section('content')
    <div class="site-container py-8 lg:py-12">
        <x-home-section-title section="testimonials" />
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($testimonials as $t)
                <blockquote class="home-testimonial-card">
                    <span class="home-testimonial-card__mark" aria-hidden="true">"</span>
                    <p class="home-testimonial-card__quote">{{ $t->quote }}</p>
                    <footer class="home-testimonial-card__footer">
                        <p class="home-testimonial-card__author">{{ $t->author_name }}</p>
                        @if ($t->author_label)
                            <p class="home-testimonial-card__label">{{ $t->author_label }}</p>
                        @endif
                    </footer>
                </blockquote>
            @empty
                <p class="col-span-full text-neutral-500 text-sm py-8 text-center">No testimonials yet. Add them in admin → Testimonials.</p>
            @endforelse
        </div>
        @if ($testimonials->hasPages())
            <div class="mt-8">{{ $testimonials->links() }}</div>
        @endif
    </div>
@endsection
