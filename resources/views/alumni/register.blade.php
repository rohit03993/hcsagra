@extends('layouts.app')

@section('seo')
    <x-seo title="Alumni Registration" description="Register as alumni of our school and stay connected." />
@endsection

@section('content')
    <div class="px-4 md:px-8 lg:px-10 py-6 md:py-10 max-w-lg mx-auto">
        <x-section-title subtitle="Alumni">Register as Alumni</x-section-title>
        <p class="text-sm text-slate-600 mb-6">Stay connected with your school community.</p>

        @if (session('success'))
            <div class="mb-6 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm p-4 font-medium">{{ session('success') }}</div>
        @endif

        <form method="post" action="{{ route('alumni.register.store') }}" class="space-y-4 rounded-2xl bg-white border border-slate-100 shadow-sm p-5 md:p-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Full name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none">
                @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none">
                @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1">Phone *</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none">
                @error('phone')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="batch_year" class="block text-sm font-semibold text-slate-700 mb-1">Batch / year of passing</label>
                <input type="text" name="batch_year" id="batch_year" value="{{ old('batch_year') }}" placeholder="e.g. 2018" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none">
            </div>
            <div>
                <label for="current_occupation" class="block text-sm font-semibold text-slate-700 mb-1">Current occupation</label>
                <input type="text" name="current_occupation" id="current_occupation" value="{{ old('current_occupation') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none">
            </div>
            <div>
                <label for="message" class="block text-sm font-semibold text-slate-700 mb-1">Message (optional)</label>
                <textarea name="message" id="message" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none">{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="w-full rounded-xl bg-brand-700 text-white font-bold py-3.5 hover:bg-brand-800 transition">Register</button>
        </form>
    </div>
@endsection
