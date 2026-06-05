@props(['compact' => false])

<nav {{ $attributes->merge(['class' => 'flex items-center justify-center flex-nowrap gap-1']) }} aria-label="Desktop">
    @foreach ($mainMenu as $item)
        @php
            $isActive = (request()->routeIs('home') && $item['label'] === 'Home')
                || (request()->routeIs('posts.*') && $item['label'] === 'Achievements');
            $linkPad = $compact ? 'px-3 py-2' : 'px-3.5 py-2';
        @endphp
        @if (! empty($item['url']))
            <a href="{{ $item['url'] }}"
               class="site-nav-link {{ $linkPad }} {{ $isActive ? 'site-nav-link--active' : '' }}">
                {{ $item['label'] }}
            </a>
        @elseif (! empty($item['children']))
            <div class="nav-dropdown relative group">
                <button type="button" class="site-nav-link site-nav-link--dropdown {{ $linkPad }}">
                    {{ $item['label'] }}
                    <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="nav-dropdown-panel absolute top-full left-1/2 -translate-x-1/2 pt-2 min-w-[13rem] opacity-0 invisible z-[60]">
                    <div class="site-nav-dropdown-panel rounded-xl py-1.5 overflow-hidden text-left">
                        @foreach ($item['children'] as $child)
                            <a href="{{ $child['url'] }}" class="block px-4 py-2.5 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-brand-900 transition">{{ $child['label'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</nav>
