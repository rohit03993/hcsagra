@props([
    'showTitle' => true,
])

@php
    $mapSrc = \App\Support\Maps::embedSrc($settings->google_maps_embed_url, $settings->address);
    $inputClass = 'home-form-input';
@endphp

@if ($showTitle)
    <x-section-title subtitle="Reach us">Contact Us</x-section-title>
@endif

<div class="grid lg:grid-cols-2 gap-6 lg:gap-10 lg:items-stretch">
    <div class="flex flex-col min-h-[320px] lg:min-h-[400px]">
        @if (session('contact_success'))
            <div class="mb-4 rounded-xl bg-accent/20 border-2 border-accent text-brand-900 text-sm p-4 font-semibold">
                {{ session('contact_success') }}
            </div>
        @endif

        <form method="post" action="{{ route('contact.store') }}" class="home-contact-form flex flex-col flex-1">
            @csrf
            <p class="home-contact-form__title">Send us a message</p>
            <div class="space-y-4 flex-1 flex flex-col">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="contact_name" class="home-form-label">Your name *</label>
                        <input type="text" name="name" id="contact_name" value="{{ old('name') }}" required class="{{ $inputClass }}">
                        @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="contact_phone" class="home-form-label">Phone *</label>
                        <input type="tel" name="phone" id="contact_phone" value="{{ old('phone') }}" required inputmode="tel" class="{{ $inputClass }}">
                        @error('phone')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label for="contact_email" class="home-form-label">Email (optional)</label>
                    <input type="email" name="email" id="contact_email" value="{{ old('email') }}" inputmode="email" class="{{ $inputClass }}">
                    @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex-1 flex flex-col min-h-0">
                    <label for="contact_message" class="home-form-label">Message *</label>
                    <textarea name="message" id="contact_message" rows="4" required class="{{ $inputClass }} flex-1 min-h-[100px]">{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <button type="submit" class="home-btn-primary mt-5 w-full">
                Send message
            </button>
        </form>
    </div>

    @if ($mapSrc)
        <div class="home-map-frame min-h-[320px] lg:min-h-[400px] h-full">
            <iframe
                src="{{ $mapSrc }}"
                class="w-full h-full min-h-[320px] lg:min-h-[400px] border-0"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen
                title="Directions to {{ $settings->school_name }}"
            ></iframe>
        </div>
    @else
        <div class="home-map-placeholder min-h-[320px] lg:min-h-[400px]">
            Add your address in <strong class="text-brand-900">Site Settings</strong> to show directions here.
        </div>
    @endif
</div>
