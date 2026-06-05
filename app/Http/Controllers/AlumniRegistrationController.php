<?php

namespace App\Http\Controllers;

use App\Models\AlumniRegistration;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AlumniRegistrationController extends Controller
{
    public function create(): View
    {
        return view('alumni.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'batch_year' => ['nullable', 'string', 'max:10'],
            'current_occupation' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        AlumniRegistration::query()->create($validated);

        $schoolEmail = SiteSetting::current()->email;
        if ($schoolEmail && config('mail.default')) {
            try {
                Mail::raw(
                    "New alumni registration\n\nName: {$validated['name']}\nEmail: {$validated['email']}\nPhone: {$validated['phone']}",
                    fn ($message) => $message->to($schoolEmail)->subject('Alumni Registration — ' . SiteSetting::current()->school_name)
                );
            } catch (\Throwable) {
                //
            }
        }

        return redirect()
            ->route('alumni.register')
            ->with('success', 'Thank you for registering as alumni! We will be in touch.');
    }
}
