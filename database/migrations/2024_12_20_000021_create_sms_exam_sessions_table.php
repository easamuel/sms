<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_exam_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('sms_exams')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('sms_students')->onDelete('cascade');
            $table->enum('status', ['in_progress', 'completed', 'abandoned', 'timeout'])->default('in_progress');
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->integer('time_remaining_seconds')->nullable();
            $table->json('answers')->nullable(); // Store student answers
            $table->integer('score')->default(0);
            $table->integer('total_score')->default(0);
            $table->decimal('percentage', 5, 2)->default(0.00);
            $table->boolean('passed')->default(false);
            $table->timestamps();
            
            $table->index(['exam_id', 'student_id', 'status']);
            $table->index(['student_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_exam_sessions');
    }
};
