<?php

namespace App\Jobs;

use App\Mail\WeeklyFeedbackSummary;
use App\Models\Feedback;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendWeeklyFeedbackSummary implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $lastWeek = now()->subWeek();

        $feedbacks = Feedback::where('submitted_on', '>=', $lastWeek)->get();

        $data = [
            'total' => $feedbacks->count(),
            'complaints' => $feedbacks->where('issues_reported', true)->count(),
            'average_rating' => $feedbacks->avg('satisfaction_rating'),
        ];

        Mail::to('rajuaji2008@gmail.com')->send(new WeeklyFeedbackSummary($data));
    }
}
