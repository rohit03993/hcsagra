@php
    use App\Support\MediaUrl;
    use Illuminate\Support\Facades\Storage;
    $path = $path ?? null;
    $field = $field ?? 'image_path';
    $removeField = '_remove_'.$field;
    $replaceField = '_replace_'.$field;
    $exists = filled($path) && Storage::disk('public')->exists($path);
    $url = $exists ? MediaUrl::public($path, versioned: true) : null;
    $imageLabel = $label ?? 'Image';
    $ratio = $ratio ?? '16:9';
@endphp

<div
    class="managed-image-panel rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900"
    x-data="{
        markedRemove: @entangle('data.'.$removeField),
        replaceMode: @entangle('data.'.$replaceField),
        storedPath: @js($path),
        clearUpload() {
            $wire.set('data.{{ $field }}', null);
        },
        markDelete() {
            this.markedRemove = true;
            this.replaceMode = false;
            this.clearUpload();
        },
        undoDelete() {
            this.markedRemove = false;
            if (this.storedPath) {
                $wire.set('data.{{ $field }}', this.storedPath);
            }
        },
        startReplace() {
            this.markedRemove = false;
            this.replaceMode = true;
            this.clearUpload();
        },
        cancelReplace() {
            this.replaceMode = false;
            if (this.storedPath) {
                $wire.set('data.{{ $field }}', this.storedPath);
            }
        }
    }"
>
    {{-- Saved image preview --}}
    @if ($url)
        <div x-show="!markedRemove && !replaceMode" x-cloak class="p-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Current {{ $imageLabel }}</p>
                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Live on website · {{ $ratio }} ratio</p>
                </div>
            </div>

            <div class="mt-3 overflow-hidden rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-950">
                <img
                    src="{{ $url }}"
                    alt="{{ $imageLabel }}"
                    class="mx-auto max-h-56 w-full object-contain"
                />
            </div>

            <div class="mt-4 flex flex-wrap gap-2">
                <button
                    type="button"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-black shadow-sm hover:bg-amber-400"
                    x-on:click="startReplace()"
                >
                    Replace image
                </button>
                <button
                    type="button"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50 dark:border-red-800 dark:bg-gray-900 dark:text-red-300 dark:hover:bg-red-950/40"
                    x-on:click="markDelete()"
                >
                    Delete image
                </button>
            </div>
        </div>
    @endif

    {{-- Marked for deletion --}}
    <div
        x-show="markedRemove"
        x-cloak
        class="p-4"
    >
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-900 dark:bg-red-950/30">
            <p class="text-sm font-semibold text-red-800 dark:text-red-200">Image will be removed</p>
            <p class="mt-1 text-sm text-red-700 dark:text-red-300">
                The preview is hidden. Click <strong>Save changes</strong> to delete this file from the server.
            </p>
            <div class="mt-4 flex flex-wrap gap-2">
                <button
                    type="button"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
                    x-on:click="undoDelete()"
                >
                    Undo
                </button>
                <button
                    type="button"
                    class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-black hover:bg-amber-400"
                    x-on:click="startReplace()"
                >
                    Upload new image instead
                </button>
            </div>
        </div>
    </div>

    {{-- No image on record --}}
    @unless ($url)
        <div class="p-4" x-show="!markedRemove">
            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">No {{ strtolower($imageLabel) }} yet</p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload an image in the box below.</p>
        </div>
    @endunless

    {{-- Replace mode hint --}}
    <div
        x-show="replaceMode && !markedRemove"
        x-cloak
        class="border-b border-gray-200 px-4 py-3 dark:border-gray-700"
    >
        <div class="flex flex-wrap items-center justify-between gap-2">
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Upload a new image below. After upload, click the thumbnail → <strong>Edit</strong> to crop ({{ $ratio }}).
            </p>
            @if ($url)
                <button
                    type="button"
                    class="text-sm font-medium text-gray-500 underline hover:text-gray-800 dark:hover:text-gray-200"
                    x-on:click="cancelReplace()"
                >
                    Cancel
                </button>
            @endif
        </div>
    </div>
</div>
