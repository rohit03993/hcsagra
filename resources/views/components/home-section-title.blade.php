@props(['section'])

@php
    $heading = $settings->homeSectionHeading($section);
@endphp

<x-section-title :subtitle="$heading['subtitle']" {{ $attributes }}>
    {{ $heading['title'] }}
</x-section-title>
