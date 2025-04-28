<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('service_date')->nullable();
            $table->tinyInteger('service_type')->default(4); // 1: Testing, 2: Calibration, 3: Inspection, 4: Other
            $table->string('job_reference')->nullable();
            $table->tinyInteger('location')->default(4); // 1: On-site, 2: Laboratory, 3: Remote, 4: Other
            $table->tinyInteger('satisfaction_rating')->nullable(); // 1 to 5
            $table->text('satisfied_aspects')->nullable();
            $table->text('improvements')->nullable();
            $table->boolean('staff_professional')->default(false);
            $table->boolean('turnaround_acceptable')->default(false);
            $table->boolean('reports_clear')->default(false);
            $table->boolean('safety_confidentiality')->default(false);
            $table->boolean('issues_reported')->default(false);
            $table->text('issue_description')->nullable();
            $table->boolean('issue_resolved')->default(false);
            $table->boolean('follow_up_requested')->default(false);
            $table->tinyInteger('preferred_contact_method')->default(1);    // 1: Email, 2: Phone
            $table->boolean('consent')->default(false);
            $table->date('submitted_on')->default(now());
            $table->tinyInteger('status')->default(1); // Open, Reviewed, Action Taken, Closed
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
