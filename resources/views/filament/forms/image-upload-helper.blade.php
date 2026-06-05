@php
    use App\Support\MediaUrl;
    use Illuminate\Support\Facades\Storage;
    $path = $path ?? null;
    $exists = filled($path) && Storage::disk('public')->exists($path);
    $url = $exists ? MediaUrl::public($path, versioned: true) : null;
    $imageLabel = $label ?? 'Image';
@endphp

@if ($url)
    <div class="rounded-xl border border-neutral-200 bg-neutral-50 p-4 dark:border-neutral-700 dark:bg-neutral-900">
        <p class="mb-3 text-sm font-semibold text-neutral-800 dark:text-neutral-200">
            Saved {{ $imageLabel }} (on website now)
        </p>
        <div class="flex justify-center rounded-lg border border-neutral-200 bg-white p-3 dark:border-neutral-600 dark:bg-neutral-950">
            <img
                src="{{ $url }}"
                alt="{{ $imageLabel }}"
                class="max-h-72 w-full max-w-full object-contain"
            />
        </div>
        <p class="mt-3 text-sm text-neutral-600 dark:text-neutral-400">
            To change: use the large upload box below — <strong>pencil</strong> to crop, <strong>X</strong> to replace.
        </p>
    </div>
@endif
