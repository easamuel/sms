<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_practice_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('sms_teachers')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('sms_classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('sms_subjects')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('availability', ['always_open', 'date_based'])->default('always_open');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('show_answers_immediately')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['teacher_id', 'class_id', 'subject_id']);
            $table->index(['class_id', 'subject_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_practice_sessions');
    }
};
