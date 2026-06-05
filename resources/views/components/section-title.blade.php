@props(['subtitle' => null])
<div {{ $attributes->merge(['class' => 'section-heading mb-6 lg:mb-8']) }}>
    <div class="section-heading__row">
        <span class="section-heading__ornament" aria-hidden="true"></span>
        <div>
            @if ($subtitle)
                <p class="section-heading__eyebrow">{{ $subtitle }}</p>
            @endif
            <h2 class="section-heading__title">{{ $slot }}</h2>
        </div>
    </div>
    <div class="section-heading__rule" aria-hidden="true">
        <span class="section-heading__rule-accent"></span>
        <span class="section-heading__rule-line"></span>
    </div>
</div>
