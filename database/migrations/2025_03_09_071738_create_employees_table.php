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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('email')->unique();
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
             $table->unsignedTinyInteger('role')->default(3); // 1 = Owner, 2 = Manager, 3 = Employee
              $table->foreignId('manager_id')->nullable()->constrained('employees')->onDelete('set null');
              $table->string('profile_pic')->nullable();
              $table->text('responsibility')->nullable();
               $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
