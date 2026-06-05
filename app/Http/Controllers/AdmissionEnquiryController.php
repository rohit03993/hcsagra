<?php

namespace App\Http\Controllers;

use App\Models\AdmissionEnquiry;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdmissionEnquiryController extends Controller
{
    public function create(): View
    {
        return view('admission.enquiry');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:120'],
            'parent_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'class_applying' => ['required', 'string', 'max:50'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $enquiry = AdmissionEnquiry::query()->create($validated);

        $schoolEmail = SiteSetting::current()->email;
        if ($schoolEmail && config('mail.default')) {
            try {
                Mail::raw(
                    "New admission enquiry\n\nStudent: {$enquiry->student_name}\nParent: {$enquiry->parent_name}\nPhone: {$enquiry->phone}\nClass: {$enquiry->class_applying}\n\nView in admin panel.",
                    fn ($message) => $message->to($schoolEmail)->subject('New Admission Enquiry — ' . SiteSetting::current()->school_name)
                );
            } catch (\Throwable) {
                // Saved in DB even if mail fails (local XAMPP often has no mail).
            }
        }

        return redirect()
            ->route('admission.enquiry')
            ->with('success', 'Thank you! Your enquiry has been submitted. We will contact you soon.');
    }
}
