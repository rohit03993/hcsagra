@props(['src', 'alt' => 'Gallery photo', 'caption' => ''])

<button
    type="button"
    {{ $attributes->merge(['class' => 'gallery-lightbox-trigger group block w-full overflow-hidden text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2']) }}
    data-full-src="{{ $src }}"
    data-caption="{{ $caption ?: $alt }}"
    aria-label="View {{ $caption ?: $alt }}"
>
    {{ $slot }}
</button>
