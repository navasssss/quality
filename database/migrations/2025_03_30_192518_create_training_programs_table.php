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
        Schema::create('training_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Employee
    $table->tinyInteger('training'); // TrainingDropdown::getTypeOptions()
    $table->tinyInteger('designation');
    $table->tinyInteger('department');
    $table->string('module'); // Training Module
    $table->date('training_date');
    $table->string('trainer_name');
    $table->tinyInteger('mode'); // Training Mode
    $table->tinyInteger('training_type');
    $table->tinyInteger('validity')->nullable(); // Months
    $table->date('refresher_due')->nullable();
    $table->tinyInteger('status'); // Completed/Pending/etc.
    $table->json('attachments')->nullable(); // Multiple files (JPG/PDF)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_programs');
    }
};
