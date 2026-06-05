@props(['title' => null, 'description' => null, 'image' => null])

@php
    $pageTitle = \App\Support\Seo::title($title, $settings->school_name ?? null);
    $metaDesc = \App\Support\Seo::description($description);
    $canonical = url()->current();
    $ogImage = $image ? \App\Support\MediaUrl::public($image) : ($settings->logo_path ? \App\Support\MediaUrl::public($settings->logo_path) : null);
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $metaDesc }}">
<link rel="canonical" href="{{ $canonical }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $metaDesc }}">
<meta property="og:url" content="{{ $canonical }}">
@if ($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
@endif
