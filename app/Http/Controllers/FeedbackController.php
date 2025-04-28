<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        // Validate and store feedback
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:feedback,email',
            'phone' => 'required|string|max:20',
            'service_date' => 'required|date',
            'service_type' => ['required','integer', Rule::in(array_keys(Feedback::service_type()))],
            'job_reference' => 'required|string|max:255',
            'location' => ['required','integer', Rule::in(array_keys(Feedback::location()))],
            'satisfaction_rating' => 'integer|min:1|max:5',
            'satisfied_aspects' => 'string|max:1000',
            'improvements' => 'required|string|max:1000',
            'staff_professional' => 'boolean',
            'turnaround_acceptable' => 'boolean',
            'reports_clear' => 'boolean',
            'safety_confidentiality' => 'boolean',
            'issues_reported' => 'boolean',
            'issue_description' => 'nullable|string|max:1000',
            'issue_resolved' => 'boolean',
            'follow_up_requested' => 'boolean',
            'preferred_contact_method' => ['required','integer', Rule::in(array_keys(Feedback::preferred_contact_method()))],
            'consent' => 'boolean',
            'submitted_on' => 'date',
        ]);

        // Store feedback in the database
        Feedback::create($validatedData);

        return redirect()->route('feedback.create')->with('success', 'Feedback submitted successfully!');
    }
}
