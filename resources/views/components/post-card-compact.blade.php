@props(['post'])
<a href="{{ route('posts.show', $post->slug) }}" class="news-list-item group flex items-center gap-3 sm:gap-4 py-3.5 sm:py-4 border-b border-neutral-200/80 last:border-0 transition-colors">
    @if ($post->image_path)
        <img src="{{ \App\Support\MediaUrl::public($post->image_path) }}" alt="" class="h-14 sm:h-16 aspect-[8/5] rounded-xl object-cover shrink-0 ring-2 ring-white shadow-sm" loading="lazy" decoding="async" width="102" height="64">
    @else
        <div class="h-14 w-14 sm:h-16 sm:w-16 rounded-xl bg-brand-900 flex items-center justify-center shrink-0 text-accent text-[10px] font-bold tracking-wide">NEWS</div>
    @endif
    <div class="min-w-0 flex-1">
        <p class="text-[10px] font-bold uppercase tracking-widest text-accent-dark">{{ $post->type->label() }}</p>
        <h3 class="text-sm sm:text-base font-semibold text-brand-900 line-clamp-2 group-hover:text-black transition-colors mt-0.5">{{ $post->title }}</h3>
        @if ($post->published_at)
            <p class="text-xs text-neutral-500 mt-1">{{ $post->published_at->format('d M Y') }}</p>
        @endif
    </div>
    <span class="news-list-item__arrow shrink-0" aria-hidden="true">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </span>
</a>
