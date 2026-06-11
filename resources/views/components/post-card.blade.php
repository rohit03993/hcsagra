@props(['post'])
<a href="{{ route('posts.show', $post->slug) }}" class="flex gap-4 rounded-xl bg-white p-4 lg:p-5 shadow-sm border border-neutral-200 hover:border-accent hover:shadow-md transition">
    @if ($post->image_path)
        <img src="{{ \App\Support\MediaUrl::public($post->image_path) }}" alt="" class="h-20 aspect-[8/5] rounded-xl object-cover shrink-0" loading="lazy" decoding="async" width="128" height="80">
    @endif
    <div class="min-w-0 flex-1">
        <p class="text-[10px] font-bold uppercase tracking-wide text-accent-dark">{{ $post->type->label() }}</p>
        <div class="flex flex-wrap items-center gap-2 mt-0.5">
            <h3 class="font-semibold text-brand-900 line-clamp-2 flex-1 min-w-0">{{ $post->title }}</h3>
            @if ($post->pdf_path)
                <span class="shrink-0 text-[10px] font-bold uppercase bg-red-100 text-red-700 px-2 py-0.5 rounded-md">PDF</span>
            @endif
        </div>
        @if ($post->excerpt)
            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $post->excerpt }}</p>
        @endif
        @if ($post->published_at)
            <p class="text-xs text-slate-400 mt-1">{{ $post->published_at->format('d M Y') }}</p>
        @endif
    </div>
</a>
