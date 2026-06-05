@props(['videoId', 'title' => 'Play video'])
@if ($videoId)
    <div
        class="youtube-embed home-video-frame relative aspect-video rounded-2xl overflow-hidden bg-brand-900 ring-1 ring-black/10 shadow-lg"
        data-youtube-embed
        data-youtube-id="{{ $videoId }}"
    >
        <button
            type="button"
            class="youtube-embed-play absolute inset-0 w-full h-full cursor-pointer group"
            data-youtube-play
            aria-label="{{ $title }}"
        >
            <img
                src="{{ \App\Support\Youtube::thumbnailUrl($videoId) }}"
                alt=""
                class="w-full h-full object-cover opacity-95 group-hover:opacity-100 transition-opacity"
                loading="lazy"
                decoding="async"
                width="640"
                height="360"
            >
            <span class="absolute inset-0 flex items-center justify-center bg-black/35 group-hover:bg-black/45 transition-colors">
                <span class="home-video-play" aria-hidden="true">
                    <svg class="w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </span>
            </span>
        </button>
    </div>
@endif
