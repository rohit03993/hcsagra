<x-filament-widgets::widget>
    <x-filament::section>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            Jump straight to the sections you change most often. Click a row to open it, or use <strong>Edit</strong> on any list.
        </p>
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($links as $link)
                <a
                    href="{{ $link['url'] }}"
                    class="group flex flex-col rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:border-primary-500 hover:shadow-md dark:border-gray-700 dark:bg-gray-900 dark:hover:border-primary-400"
                >
                    <span class="font-semibold text-gray-950 group-hover:text-primary-600 dark:text-white dark:group-hover:text-primary-400">
                        {{ $link['label'] }}
                    </span>
                    <span class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $link['hint'] }}</span>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
