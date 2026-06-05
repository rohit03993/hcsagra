<x-filament-widgets::widget>
    <x-filament::section>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            Replace demo placeholders with your school content. Use <strong>Quick edit</strong> above or open any section from the sidebar. Guide: <strong>CONTENT.md</strong>.
        </p>
        <ul class="space-y-2">
            @foreach ($items as $item)
                <li class="flex items-center gap-2 text-sm">
                    @if ($item['done'])
                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-success-500 text-white text-xs" aria-hidden="true">✓</span>
                        <span class="text-gray-700 dark:text-gray-300 line-through opacity-70">{{ $item['label'] }}</span>
                    @else
                        <span class="flex h-5 w-5 items-center justify-center rounded-full border-2 border-gray-300 dark:border-gray-600" aria-hidden="true"></span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    </x-filament::section>
</x-filament-widgets::widget>
