@extends('layouts.app')

@section('seo')
    <x-seo title="Admission Enquiry" :description="'Apply for admission at ' . $settings->school_name" />
@endsection

@section('content')
    <div class="px-4 md:px-8 lg:px-10 py-6 md:py-10 max-w-lg mx-auto">
        <x-section-title subtitle="Admissions">Admission Enquiry</x-section-title>
        <p class="text-sm text-slate-600 mb-6">Fill the form below and our team will contact you.</p>

        @if (session('success'))
            <div class="mb-6 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm p-4 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <form method="post" action="{{ route('admission.enquiry.store') }}" class="space-y-4 rounded-2xl bg-white border border-slate-100 shadow-sm p-5 md:p-6">
            @csrf
            <div>
                <label for="student_name" class="block text-sm font-semibold text-slate-700 mb-1">Student name *</label>
                <input type="text" name="student_name" id="student_name" value="{{ old('student_name') }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none">
                @error('student_name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="parent_name" class="block text-sm font-semibold text-slate-700 mb-1">Parent / Guardian name *</label>
                <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none">
                @error('parent_name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1">Phone *</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required inputmode="tel"
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none">
                @error('phone')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email (optional)</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" inputmode="email"
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none">
                @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="class_applying" class="block text-sm font-semibold text-slate-700 mb-1">Class applying for *</label>
                <select name="class_applying" id="class_applying" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none bg-white">
                    <option value="">Select class</option>
                    @foreach (['Nursery', 'LKG', 'UKG', 'Class I', 'Class II', 'Class III', 'Class IV', 'Class V', 'Class VI', 'Class VII', 'Class VIII', 'Class IX', 'Class XI'] as $class)
                        <option value="{{ $class }}" @selected(old('class_applying') === $class)>{{ $class }}</option>
                    @endforeach
                </select>
                @error('class_applying')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="message" class="block text-sm font-semibold text-slate-700 mb-1">Message (optional)</label>
                <textarea name="message" id="message" rows="3"
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-base focus:border-brand-600 focus:ring-2 focus:ring-brand-100 outline-none">{{ old('message') }}</textarea>
                @error('message')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="w-full rounded-xl bg-brand-700 text-white font-bold py-3.5 text-base hover:bg-brand-800 active:scale-[0.99] transition">
                Submit Enquiry
            </button>
        </form>
    </div>
@endsection
