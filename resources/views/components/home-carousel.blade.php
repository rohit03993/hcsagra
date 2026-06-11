@props([
    'desktopCols' => 3,
    'slides' => 0,
])

<div {{ $attributes->merge(['class' => 'home-carousel']) }} data-desktop-cols="{{ $desktopCols }}">
    <div class="home-carousel__track no-scrollbar">
        {{ $slot }}
    </div>
    @if ((int) $slides > 1)
        <button type="button" class="home-carousel__prev hero-nav-btn home-carousel__nav home-carousel__nav--prev" aria-label="Previous">
            <x-site-icon name="chevron-left" class="w-5 h-5" />
        </button>
        <button type="button" class="home-carousel__next hero-nav-btn home-carousel__nav home-carousel__nav--next" aria-label="Next">
            <x-site-icon name="chevron-right" class="w-5 h-5" />
        </button>
    @endif
</div>
