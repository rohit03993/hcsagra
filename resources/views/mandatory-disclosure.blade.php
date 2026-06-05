@extends('layouts.app')

@section('seo')
    <x-seo title="Mandatory Disclosure" :description="$page?->meta_description ?? 'CBSE mandatory disclosure documents.'" />
@endsection

@section('content')
    <div class="px-4 md:px-8 lg:px-10 py-6 md:py-10 max-w-3xl mx-auto">
        <x-section-title subtitle="CBSE">Mandatory Disclosure</x-section-title>

        @if ($page?->body)
            <div class="prose prose-sm prose-slate max-w-none mb-8">
                {!! $page->body !!}
            </div>
        @else
            <p class="text-sm text-slate-600 mb-8">Official documents as per CBSE norms. Click to view or download PDF.</p>
        @endif

        <div class="space-y-3">
            @forelse ($documents as $doc)
                <a href="{{ \App\Support\MediaUrl::public($doc->pdf_path) }}" target="_blank" rel="noopener"
                   class="flex items-center gap-4 rounded-2xl bg-white border border-slate-100 p-4 shadow-sm hover:border-brand-300 hover:shadow-md transition group">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600 font-bold text-xs">PDF</span>
                    <span class="flex-1 min-w-0">
                        <span class="font-semibold text-brand-900 group-hover:text-brand-700 block">{{ $doc->title }}</span>
                        <span class="text-xs text-slate-500">Tap to open document</span>
                    </span>
                    <span class="text-brand-700 text-sm font-semibold shrink-0">Open →</span>
                </a>
            @empty
                <p class="text-slate-500 text-sm rounded-xl bg-slate-50 p-6 text-center">Documents will be published here soon.</p>
            @endforelse
        </div>
    </div>
@endsection
