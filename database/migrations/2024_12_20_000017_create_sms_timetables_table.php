<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('sms_classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('sms_subjects')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('sms_teachers')->onDelete('cascade');
            $table->enum('day', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('period_number')->nullable(); // e.g., "Period 1", "Period 2"
            $table->string('academic_year');
            $table->string('term')->nullable(); // First Term, Second Term, Third Term
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['class_id', 'day', 'academic_year']);
            $table->index(['teacher_id', 'day', 'academic_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_timetables');
    }
};
