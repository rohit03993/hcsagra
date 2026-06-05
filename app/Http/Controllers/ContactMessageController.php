<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $message = ContactMessage::query()->create($validated);

        $schoolEmail = SiteSetting::current()->email;
        if ($schoolEmail && config('mail.default')) {
            try {
                Mail::raw(
                    "New contact message\n\nName: {$message->name}\nPhone: {$message->phone}\nEmail: " . ($message->email ?? '—') . "\n\n{$message->message}\n\nView in admin panel.",
                    fn ($mail) => $mail->to($schoolEmail)->subject('New Contact Message — ' . SiteSetting::current()->school_name)
                );
            } catch (\Throwable) {
                // Saved in DB even if mail fails.
            }
        }

        return redirect()
            ->to(route('home') . '#contact')
            ->with('contact_success', 'Thank you! Your message has been sent. We will get back to you soon.');
    }
}
