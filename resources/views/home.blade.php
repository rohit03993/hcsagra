@extends('layouts.app')

@section('seo')
    <x-seo :title="$settings->school_name" :description="$settings->default_meta_description ?: $settings->about_text" />
@endsection

@section('content')
    @if ($slides->isNotEmpty())
        <section class="home-hero-section" aria-label="School highlights">
            <div class="home-hero-section__frame">
                <div class="hero-slider home-hero relative overflow-hidden">
                    <div class="hero-track flex overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar">
                        @foreach ($slides as $slide)
                            @php
                                $hasTitle = filled($slide->title);
                                $hasSubtitle = filled($slide->subtitle);
                                $hasButton = filled($slide->button_text);
                                $hasCaption = $hasTitle || $hasSubtitle || $hasButton;
                                $buttonHref = $hasButton ? ($slide->button_url ?: $settings->admissionUrl()) : null;
                            @endphp
                            <div class="hero-slide min-w-full snap-center relative shrink-0 aspect-[16/9]">
                                <img
                                    src="{{ \App\Support\MediaUrl::public($slide->image_path) }}"
                                    alt="{{ $slide->title ?: $settings->school_name }}"
                                    class="block w-full h-full object-cover object-center"
                                    @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif
                                    decoding="async"
                                    width="1200"
                                    height="675"
                                >
                                @if ($hasCaption)
                                    <div class="home-hero__overlay absolute inset-0"></div>
                                    <div class="home-hero__content absolute bottom-0 left-0 right-0">
                                        <div class="site-container">
                                            <div class="home-hero__caption">
                                                @if ($hasTitle)
                                                    <h2 class="home-hero__title">{{ $slide->title }}</h2>
                                                @endif
                                                @if ($hasSubtitle)
                                                    <p class="home-hero__subtitle">{{ $slide->subtitle }}</p>
                                                @endif
                                                @if ($hasButton)
                                                    <a href="{{ $buttonHref }}" class="home-btn-primary home-hero__cta">{{ $slide->button_text }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @if ($slides->count() > 1)
                        <button type="button" class="hero-prev hero-nav-btn home-hero__nav home-hero__nav--prev absolute left-3 sm:left-5 top-1/2 -translate-y-1/2 z-20" aria-label="Previous slide">
                            <x-site-icon name="chevron-left" class="w-6 h-6" />
                        </button>
                        <button type="button" class="hero-next hero-nav-btn home-hero__nav home-hero__nav--next absolute right-3 sm:right-5 top-1/2 -translate-y-1/2 z-20" aria-label="Next slide">
                            <x-site-icon name="chevron-right" class="w-6 h-6" />
                        </button>
                    @endif
                </div>
            </div>
        </section>
    @else
        <section class="home-hero-fallback" aria-label="Welcome">
            <div class="site-container">
                <div class="home-hero-fallback__inner">
                    <p class="home-hero-fallback__eyebrow">Welcome</p>
                    <h1 class="home-hero-fallback__title">{{ $settings->school_name }}</h1>
                    @if ($settings->tagline)
                        <p class="home-hero-fallback__tagline">{{ $settings->tagline }}</p>
                    @endif
                    <a href="{{ $settings->admissionUrl() }}" class="home-btn-primary">Apply for Admission</a>
                </div>
            </div>
        </section>
    @endif

    <x-school-quick-links />

    <section class="site-container home-section">
        <div class="home-about">
            <div class="home-about__main">
                <x-home-section-title section="about" />
                <div class="home-about__panel">
                    <p class="home-lead">
                        {{ $settings->about_text ?: $settings->tagline ?: 'We are committed to providing quality education in a safe, caring environment where every child can achieve their full potential.' }}
                    </p>
                </div>
                <div class="home-link-row">
                    <a href="{{ route('pages.show', $settings->mission_vision_page_slug ?: 'vision-mission') }}" class="home-btn-outline">Our Vision &amp; Mission</a>
                    <a href="{{ $settings->admissionUrl() }}" class="home-btn-primary">Admission Enquiry</a>
                </div>
            </div>
            <div class="home-about__cards">
                @if ($settings->affiliation_line)
                    <div class="home-info-card home-info-card--light">
                        <span class="home-info-card__icon" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </span>
                        <p class="home-info-card__label">Affiliation</p>
                        <p class="home-info-card__value">{{ $settings->affiliation_line }}</p>
                    </div>
                @endif
                @if ($settings->tagline)
                    <div class="home-info-card home-info-card--dark">
                        <span class="home-info-card__icon home-info-card__icon--light" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </span>
                        <p class="home-info-card__label home-info-card__label--accent">School motto</p>
                        <p class="home-info-card__value">{{ $settings->tagline }}</p>
                    </div>
                @endif
                @if ($settings->phone)
                    <a href="tel:{{ preg_replace('/\D+/', '', $settings->phone) }}" class="home-info-card home-info-card--outline">
                        <span class="home-info-card__icon" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        <p class="home-info-card__label">Call the school</p>
                        <p class="home-info-card__value">{{ $settings->phone }}</p>
                    </a>
                @endif
                <a href="{{ route('contact') }}" class="home-info-card home-info-card--accent">
                    <span class="home-info-card__icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </span>
                    <p class="home-info-card__label">Visit us</p>
                    <p class="home-info-card__value">Contact &amp; directions</p>
                </a>
            </div>
        </div>
    </section>

    @if ($settings->showsNewsSection() && ($announcements->isNotEmpty() || $achievements->isNotEmpty() || $events->isNotEmpty()))
        <section class="home-band home-band--cream">
            <div class="site-container home-section home-section--in-band home-section--tight-top" id="updates">
                <x-home-section-title section="news" />
                @php $firstNewsTab = true; @endphp
                <div class="news-tabs" role="tablist">
                    @foreach ([
                        ['id' => 'announcement', 'label' => 'Announcements', 'items' => $announcements],
                        ['id' => 'achievement', 'label' => 'Achievements', 'items' => $achievements],
                        ['id' => 'event', 'label' => 'Events', 'items' => $events],
                    ] as $tab)
                        @if ($tab['items']->isNotEmpty())
                            <button type="button" role="tab" data-tab="{{ $tab['id'] }}" class="news-tab {{ $firstNewsTab ? 'is-active' : '' }}" aria-selected="{{ $firstNewsTab ? 'true' : 'false' }}">
                                {{ $tab['label'] }}
                            </button>
                            @php $firstNewsTab = false; @endphp
                        @endif
                    @endforeach
                </div>
                @php $firstNewsPanel = true; @endphp
                    @foreach ([
                        ['id' => 'announcement', 'items' => $announcements, 'hasMore' => $hasMoreAnnouncements],
                        ['id' => 'achievement', 'items' => $achievements, 'hasMore' => $hasMoreAchievements],
                        ['id' => 'event', 'items' => $events, 'hasMore' => $hasMoreEvents],
                    ] as $panel)
                        @if ($panel['items']->isNotEmpty())
                            <div class="news-panel {{ $firstNewsPanel ? '' : 'hidden' }}" data-panel="{{ $panel['id'] }}" role="tabpanel">
                                @php $firstNewsPanel = false; @endphp
                                @foreach ($panel['items'] as $post)
                                    <x-post-card-compact :post="$post" />
                                @endforeach
                                @if ($panel['hasMore'])
                                    <div class="news-panel__footer">
                                        <a href="{{ route('posts.index', ['type' => $panel['id']]) }}" class="home-text-link">See all</a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
            </div>
        </section>
    @endif

    @if ($settings->mission_text || $settings->vision_text)
        <section class="site-container home-section">
            <x-home-section-title section="mission" />
            <div class="home-mv-grid">
                @if ($settings->mission_text)
                    <div class="home-mv-card home-mv-card--mission">
                        <p class="home-mv-card__eyebrow">Mission</p>
                        <h3 class="home-mv-card__title">{{ $settings->mission_title ?: 'Our Mission' }}</h3>
                        <p class="home-mv-card__body">{{ $settings->mission_text }}</p>
                        @if ($settings->mission_vision_page_slug)
                            <a href="{{ route('pages.show', $settings->mission_vision_page_slug) }}" class="home-mv-card__link">Read full statement</a>
                        @endif
                    </div>
                @endif
                @if ($settings->vision_text)
                    <div class="home-mv-card home-mv-card--vision">
                        <p class="home-mv-card__eyebrow">Vision</p>
                        <h3 class="home-mv-card__title">{{ $settings->vision_title ?: 'Our Vision' }}</h3>
                        <p class="home-mv-card__body">{{ $settings->vision_text }}</p>
                        @if ($settings->mission_vision_page_slug)
                            <a href="{{ route('pages.show', $settings->mission_vision_page_slug) }}" class="home-mv-card__link home-mv-card__link--dark">Read full statement</a>
                        @endif
                    </div>
                @endif
            </div>
        </section>
    @endif

    @if ($deskMessages->isNotEmpty())
        <section class="home-band home-band--cream">
            <div class="site-container home-section home-section--in-band">
                <div class="home-section-header">
                    <x-home-section-title section="leadership" class="!mb-0" />
                    @if ($hasMoreDeskMessages)
                        <a href="{{ route('leadership') }}" class="home-text-link home-section-header__action">See all</a>
                    @endif
                </div>
                <x-home-carousel :desktop-cols="2" :slides="$deskMessages->count()">
                    @foreach ($deskMessages as $message)
                        <article class="home-carousel__slide home-desk-card">
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
                    @endforeach
                </x-home-carousel>
            </div>
        </section>
    @endif

    @if ($facilities->isNotEmpty())
        <section class="site-container home-section" id="facilities">
            <div class="home-section-header">
                <x-home-section-title section="facilities" class="!mb-0" />
                @if ($hasMoreFacilities)
                    <a href="{{ route('facilities') }}" class="home-text-link home-section-header__action">See all</a>
                @endif
            </div>
            <x-home-carousel :desktop-cols="3" :slides="$facilities->count()">
                @foreach ($facilities as $facility)
                    <div class="home-carousel__slide home-facility-card">
                        @if ($facility->image_path)
                            <div class="home-facility-card__media">
                                <img src="{{ \App\Support\MediaUrl::public($facility->image_path) }}" alt="{{ $facility->name }}" loading="lazy" width="280" height="160">
                            </div>
                        @else
                            <div class="home-facility-card__media home-facility-card__media--placeholder" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                        @endif
                        <p class="home-facility-card__title">{{ $facility->name }}</p>
                    </div>
                @endforeach
            </x-home-carousel>
        </section>
    @endif

    @if ($gallery->isNotEmpty())
        <section class="home-band home-band--cream">
            <div class="site-container home-section home-section--in-band">
                <div class="home-section-header">
                    <x-home-section-title section="gallery" class="!mb-0" />
                    @if ($hasMoreGallery)
                        <a href="{{ route('gallery') }}" class="home-text-link home-section-header__action">See all</a>
                    @endif
                </div>
                <x-home-carousel :desktop-cols="6" :slides="$gallery->count()" data-gallery-grid>
                    @foreach ($gallery as $item)
                        @php
                            $gSrc = \App\Support\MediaUrl::public($item->image_path);
                            $gTitle = $item->title ?? 'Gallery';
                        @endphp
                        <x-gallery-thumb :src="$gSrc" :caption="$gTitle" class="home-carousel__slide home-gallery-item">
                            <img src="{{ $gSrc }}" alt="{{ $gTitle }}" loading="lazy" width="200" height="200">
                        </x-gallery-thumb>
                    @endforeach
                </x-home-carousel>
            </div>
        </section>
    @endif

    @if ($testimonials->isNotEmpty())
        <section class="site-container home-section">
            <div class="home-section-header">
                <x-home-section-title section="testimonials" class="!mb-0" />
                @if ($hasMoreTestimonials)
                    <a href="{{ route('testimonials') }}" class="home-text-link home-section-header__action">See all</a>
                @endif
            </div>
            <x-home-carousel :desktop-cols="3" :slides="$testimonials->count()">
                @foreach ($testimonials as $t)
                    <blockquote class="home-carousel__slide home-testimonial-card">
                        <span class="home-testimonial-card__mark" aria-hidden="true">"</span>
                        <p class="home-testimonial-card__quote">{{ $t->quote }}</p>
                        <footer class="home-testimonial-card__footer">
                            <p class="home-testimonial-card__author">{{ $t->author_name }}</p>
                            @if ($t->author_label)
                                <p class="home-testimonial-card__label">{{ $t->author_label }}</p>
                            @endif
                        </footer>
                    </blockquote>
                @endforeach
            </x-home-carousel>
        </section>
    @endif

    @if ($videos->isNotEmpty())
        <section class="home-band home-band--cream">
            <div class="site-container home-section home-section--in-band">
                <div class="home-section-header">
                    <x-home-section-title section="videos" class="!mb-0" />
                    @if ($hasMoreVideos)
                        <a href="{{ route('videos') }}" class="home-text-link home-section-header__action">See all</a>
                    @endif
                </div>
                <x-home-carousel :desktop-cols="4" :slides="$videos->count()">
                    @foreach ($videos as $video)
                        <div class="home-carousel__slide home-video-card">
                            <x-youtube-lite :video-id="$video->youtube_id" :title="$video->title" />
                            <p class="home-video-card__title">{{ $video->title }}</p>
                        </div>
                    @endforeach
                </x-home-carousel>
            </div>
        </section>
    @endif

    <section class="home-band home-band--contact scroll-mt-24" id="contact">
        <div class="site-container home-section home-section--in-band home-section--last">
            <x-site-contact-section />
        </div>
    </section>
@endsection
