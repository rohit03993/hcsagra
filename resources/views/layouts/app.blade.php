<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0a0a0a">
    @hasSection('seo')
        @yield('seo')
    @else
        <x-seo />
    @endif
    @if ($settings->favicon_path ?? null)
        <link rel="icon" href="{{ \App\Support\MediaUrl::public($settings->favicon_path) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Source+Serif+4:ital,opsz,wght@0,8..60,600;0,8..60,700;1,8..60,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/site.js'])
    <x-google-analytics />
    @stack('head')
</head>
<body class="site-body text-neutral-900 antialiased {{ request()->routeIs('home') ? 'page-home' : '' }}">
    {{-- Mobile menu (outside site-shell so fixed positioning works) --}}
    <div class="menu-backdrop xl:hidden" aria-hidden="true" data-menu-backdrop></div>
    <aside id="mobile-menu" class="menu-drawer flex flex-col xl:hidden" aria-hidden="true">
        <div class="flex items-center justify-between p-4 bg-brand-900 border-b-4 border-accent shrink-0">
            <span class="font-bold text-accent text-lg">Menu</span>
            <button type="button" class="menu-close text-white p-2 min-h-[44px] min-w-[44px] flex items-center justify-center" aria-label="Close menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto overscroll-contain p-3 text-sm">
            @foreach ($mainMenu as $item)
                @if (! empty($item['url']))
                    <a href="{{ $item['url'] }}" class="menu-link block rounded-lg px-4 py-3.5 font-semibold text-brand-900 hover:bg-accent hover:text-black mb-0.5">{{ $item['label'] }}</a>
                @elseif (! empty($item['children']))
                    <p class="px-4 pt-4 pb-1 text-[10px] font-bold uppercase tracking-widest text-neutral-500">{{ $item['label'] }}</p>
                    @foreach ($item['children'] as $child)
                        <a href="{{ $child['url'] }}" class="menu-link block rounded-lg px-4 py-3 text-neutral-700 hover:bg-neutral-100 pl-6 mb-0.5">{{ $child['label'] }}</a>
                    @endforeach
                @endif
            @endforeach
        </nav>
    </aside>

    <div class="site-shell relative mx-auto w-full min-h-screen">
        <x-school-top-bar />
        <header class="site-header sticky top-0 z-50 overflow-visible">
            <div class="site-container site-header__row">
                <a href="{{ route('home') }}" class="school-brand min-w-0 shrink-0 {{ ($settings->logo_path ?? null) ? 'school-brand--logo-only' : '' }}">
                    @if ($settings->logo_path ?? null)
                        <img
                            src="{{ \App\Support\MediaUrl::public($settings->logo_path) }}"
                            alt="{{ $settings->school_name }}"
                            class="school-brand__logo-image"
                            width="320"
                            height="80"
                            decoding="async"
                            fetchpriority="high"
                        >
                    @else
                        <span class="school-brand__text min-w-0">
                            <span class="school-brand__name">{{ $settings->school_name }}</span>
                            @if ($settings->tagline)
                                <span class="school-brand__affiliation">{{ $settings->tagline }}</span>
                            @endif
                        </span>
                    @endif
                </a>

                <div class="hidden xl:flex flex-1 min-w-0 justify-center px-2">
                    <x-desktop-nav compact class="flex-nowrap" />
                </div>

                <div class="flex items-center gap-2 ml-auto shrink-0">
                    {{-- Mobile only (wrapper hides on xl+; avoids custom .site-header-cta overriding xl:hidden) --}}
                    <div class="flex items-center gap-2 xl:hidden">
                        @if ($settings->phone)
                            <a href="tel:{{ preg_replace('/\D+/', '', $settings->phone) }}" class="site-header-cta site-header-cta--ghost">Call</a>
                        @endif
                        <button type="button" class="js-menu-toggle site-header-menu-btn" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                    </div>
                    {{-- Desktop only --}}
                    <div class="hidden xl:flex items-center gap-2.5">
                        @if ($settings->phone)
                            <a href="tel:{{ preg_replace('/\D+/', '', $settings->phone) }}" class="site-header-cta site-header-cta--ghost">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                Call
                            </a>
                        @endif
                        <a href="{{ $settings->admissionUrl() }}" class="site-header-cta site-header-cta--primary">Admission</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="min-h-[60vh] pb-28 xl:pb-0">
            @yield('content')
        </main>

        @if ($settings->whatsapp_url)
            <div class="site-fabs fixed z-30 right-4 bottom-[5.5rem] xl:bottom-8 xl:right-8 xl:z-40 pointer-events-none">
                <a href="{{ $settings->whatsapp_url }}" target="_blank" rel="noopener" class="whatsapp-fab whatsapp-fab--cycle fab-btn pointer-events-auto" aria-label="Chat with us now on WhatsApp">
                    <span class="whatsapp-fab__stage">
                        <span class="whatsapp-fab__icon" aria-hidden="true">
                            <x-site-icon name="whatsapp" class="w-6 h-6" />
                        </span>
                        <span class="whatsapp-fab__label">Chat with us now</span>
                    </span>
                </a>
            </div>
        @endif

        <nav class="mobile-bottom-nav xl:hidden fixed bottom-0 inset-x-0 z-50 safe-bottom" aria-label="Main">
            <div class="mobile-bottom-nav__inner grid grid-cols-4">
                <a href="{{ route('home') }}" class="mobile-bottom-nav__item {{ request()->routeIs('home') ? 'is-active' : '' }}">
                    <svg class="mobile-bottom-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/></svg>
                    <span>Home</span>
                </a>
                <a href="{{ route('admission.enquiry') }}" class="mobile-bottom-nav__item {{ request()->routeIs('admission.*') ? 'is-active' : '' }}">
                    <svg class="mobile-bottom-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Admission</span>
                </a>
                @if ($settings->phone)
                    <a href="tel:{{ preg_replace('/\D+/', '', $settings->phone) }}" class="mobile-bottom-nav__item">
                        <svg class="mobile-bottom-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>Call</span>
                    </a>
                @else
                    <a href="{{ route('home') }}#contact" class="mobile-bottom-nav__item">
                        <svg class="mobile-bottom-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Contact</span>
                    </a>
                @endif
                <button type="button" class="js-menu-toggle mobile-bottom-nav__item mobile-bottom-nav__item--btn" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
                    <svg class="mobile-bottom-nav__icon pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <span class="pointer-events-none">Menu</span>
                </button>
            </div>
        </nav>

        <x-site-footer />
    </div>

    {{-- Gallery lightbox --}}
    <div id="gallery-lightbox" class="gallery-lightbox hidden" role="dialog" aria-modal="true" aria-label="Photo viewer" aria-hidden="true">
        <div class="gallery-lightbox-backdrop absolute inset-0 bg-black/90" data-lightbox-close></div>
        <div class="relative z-10 flex flex-col items-center justify-center min-h-full p-4 pointer-events-none">
            <button type="button" class="gallery-lightbox-close pointer-events-auto absolute top-4 right-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20" data-lightbox-close aria-label="Close">
                <x-site-icon name="close" class="w-6 h-6" />
            </button>
            <button type="button" class="gallery-lightbox-prev pointer-events-auto absolute left-2 sm:left-6 top-1/2 -translate-y-1/2 hero-nav-btn" aria-label="Previous photo">
                <x-site-icon name="chevron-left" class="w-6 h-6" />
            </button>
            <button type="button" class="gallery-lightbox-next pointer-events-auto absolute right-2 sm:right-6 top-1/2 -translate-y-1/2 hero-nav-btn" aria-label="Next photo">
                <x-site-icon name="chevron-right" class="w-6 h-6" />
            </button>
            <img src="" alt="" class="gallery-lightbox-img pointer-events-auto max-w-full max-h-[min(80vh,720px)] rounded-lg shadow-2xl object-contain" width="1200" height="800">
            <p class="gallery-lightbox-caption pointer-events-auto mt-4 text-sm text-neutral-300 text-center max-w-lg"></p>
        </div>
    </div>
</body>
</html>
