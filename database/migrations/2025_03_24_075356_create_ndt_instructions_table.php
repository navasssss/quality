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
        Schema::create('ndt_instructions', function (Blueprint $table) {
            $table->id();
             $table->string('number')->unique();
            $table->string('title');
            $table->string('file'); // Stores PDF file path
            $table->integer('revision');
            $table->date('create_date');
            $table->date('approved_date')->nullable();

            // Foreign keys for prepared, reviewed, and approved by
            $table->foreignId('prepared_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewed_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->constrained('users')->onDelete('cascade');
//foreignId for audited_by as nullable
            $table->foreignId('audited_by')->nullable()->constrained('users')->nullOnDelete();
  
            $table->text('comments')->nullable();
            $table->boolean('auditable')->default(false); // Toggle for auditable
          $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ndt_instructions');
    }
};
