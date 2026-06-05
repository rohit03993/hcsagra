@extends('layouts.app')

@section('seo')
    <x-seo :title="$type->label()" :description="'Latest ' . strtolower($type->label()) . ' from ' . $settings->school_name" />
@endsection

@section('content')
    <div class="site-container py-5 md:py-8">
        <h1 class="text-xl font-bold text-brand-900">{{ $type->label() }}</h1>
        <div class="flex gap-2 mt-3 overflow-x-auto no-scrollbar text-sm">
            @foreach (\App\Enums\PostType::cases() as $t)
                <a href="{{ route('posts.index', ['type' => $t->value]) }}"
                   class="shrink-0 rounded-full px-3 py-1.5 {{ $type === $t ? 'bg-brand-700 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">
                    {{ $t->label() }}
                </a>
            @endforeach
        </div>
        <div class="space-y-3 mt-5">
            @forelse ($posts as $post)
                <x-post-card :post="$post" />
            @empty
                <p class="text-slate-500 text-sm">No items published yet.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $posts->withQueryString()->links() }}</div>
    </div>
@endsection
