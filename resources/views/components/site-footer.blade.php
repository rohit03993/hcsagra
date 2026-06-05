@php
    $mapSrc = \App\Support\Maps::embedSrc($settings->google_maps_embed_url, $settings->address);
@endphp

<footer class="site-footer site-band bg-brand-900 text-neutral-400 text-sm border-t-4 border-accent mb-20 xl:mb-0">
    <div class="site-container py-10 lg:py-14">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8">
            {{-- Brand block --}}
            <div class="lg:col-span-4 space-y-4">
                <div>
                    <p class="site-footer__name font-bold text-white text-xl tracking-tight">{{ $settings->school_name }}</p>
                    @if ($settings->affiliation_line)
                        <p class="text-xs text-neutral-500 mt-1">{{ $settings->affiliation_line }}</p>
                    @endif
                </div>
                @if ($settings->address)
                    <p class="text-xs text-neutral-400 leading-relaxed">{{ $settings->address }}</p>
                @endif
                <ul class="space-y-2 text-xs">
                    @if ($settings->phone)
                        <li>
                            <a href="tel:{{ preg_replace('/\D+/', '', $settings->phone) }}" class="inline-flex items-center gap-2 text-white hover:text-accent transition">
                                <x-site-icon name="phone" class="w-4 h-4 shrink-0 text-accent" />
                                {{ $settings->phone }}
                            </a>
                        </li>
                    @endif
                    @if ($settings->email)
                        <li>
                            <a href="mailto:{{ $settings->email }}" class="inline-flex items-center gap-2 text-white hover:text-accent transition break-all">
                                <x-site-icon name="mail" class="w-4 h-4 shrink-0 text-accent" />
                                {{ $settings->email }}
                            </a>
                        </li>
                    @endif
                </ul>
                @if ($settings->facebook_url || $settings->instagram_url || $settings->youtube_channel_url)
                    <div class="flex flex-wrap gap-2.5 pt-1">
                        @if ($settings->facebook_url)
                            <a href="{{ $settings->facebook_url }}" class="social-icon-btn" rel="noopener noreferrer" target="_blank" aria-label="Facebook">
                                <x-site-icon name="facebook" class="w-4 h-4" />
                            </a>
                        @endif
                        @if ($settings->instagram_url)
                            <a href="{{ $settings->instagram_url }}" class="social-icon-btn" rel="noopener noreferrer" target="_blank" aria-label="Instagram">
                                <x-site-icon name="instagram" class="w-4 h-4" />
                            </a>
                        @endif
                        @if ($settings->youtube_channel_url)
                            <a href="{{ $settings->youtube_channel_url }}" class="social-icon-btn" rel="noopener noreferrer" target="_blank" aria-label="YouTube">
                                <x-site-icon name="youtube" class="w-4 h-4" />
                            </a>
                        @endif
                    </div>
                @endif
                <div class="flex flex-wrap gap-2 pt-2">
                    <a href="{{ $settings->admissionUrl() }}" class="inline-flex rounded-lg bg-accent text-black text-xs font-bold px-4 py-2.5 hover:bg-accent-dark transition">
                        Admission Enquiry
                    </a>
                    @if ($mapSrc)
                        <a href="{{ route('contact') }}#map" class="inline-flex rounded-lg border border-neutral-600 text-white text-xs font-semibold px-4 py-2.5 hover:border-accent hover:text-accent transition">
                            Get directions
                        </a>
                    @endif
                </div>
            </div>

            {{-- Link columns --}}
            <div class="lg:col-span-8 grid grid-cols-2 sm:grid-cols-4 gap-6 sm:gap-8">
                @foreach ($footerColumns as $heading => $links)
                    <div>
                        <p class="font-bold text-accent text-sm mb-3 pb-1 border-b border-white/10">{{ $heading }}</p>
                        <ul class="space-y-2.5 text-xs">
                            @foreach ($links as $link)
                                <li>
                                    <a href="{{ $link['url'] }}" class="text-neutral-400 hover:text-white transition inline-block">
                                        {{ $link['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-white/10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-neutral-500">
            <p>&copy; {{ date('Y') }} {{ $settings->school_name }}. All rights reserved.</p>
            <div class="flex flex-wrap gap-x-4 gap-y-1">
                <a href="{{ $settings->mandatoryDisclosureUrl() }}" class="hover:text-accent transition">Mandatory Disclosure</a>
                <a href="{{ route('sitemap') }}" class="hover:text-accent transition">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
