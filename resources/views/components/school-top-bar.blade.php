<div class="school-top-bar hidden lg:block" aria-label="School contact">
    <div class="site-container school-top-bar__inner">
        <p class="school-top-bar__tagline">
            <span class="school-top-bar__badge" aria-hidden="true"></span>
            Nurturing excellence in academics &amp; character
        </p>
        <div class="school-top-bar__contacts">
            @if ($settings->phone)
                <a href="tel:{{ preg_replace('/\D+/', '', $settings->phone) }}" class="school-top-bar__link">
                    <x-site-icon name="phone" class="w-3.5 h-3.5 text-accent shrink-0" />
                    {{ $settings->phone }}
                </a>
            @endif
            @if ($settings->email)
                <a href="mailto:{{ $settings->email }}" class="school-top-bar__link">
                    <x-site-icon name="mail" class="w-3.5 h-3.5 text-accent shrink-0" />
                    <span class="truncate max-w-[14rem]">{{ $settings->email }}</span>
                </a>
            @endif
        </div>
        <a href="{{ $settings->admissionUrl() }}" class="school-top-bar__cta">Admissions Open</a>
    </div>
</div>
