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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('asset_number')->unique();
            $table->string('equipment_name');
            $table->string('equipment_party');
            $table->string('test_method');
            $table->string('manufacturer');
            $table->string('manufacturer_model');
            $table->string('serial_number')->unique();
            $table->date('calibration_date')->nullable();
            $table->integer('frequency')->nullable();
            $table->date('due_date')->nullable();
               $table->tinyInteger('status')->default(1);
                $table->tinyInteger('condition')->default(1);;
            $table->text('repair_details')->nullable();
            $table->string('certificate')->nullable(); // File upload
            $table->json('photographs')->nullable(); // File upload
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
