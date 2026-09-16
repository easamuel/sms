<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('sms_assignments')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('sms_students')->onDelete('cascade');
            $table->enum('submission_type', ['online', 'offline'])->default('online');
            $table->json('answers')->nullable(); // For online submissions
            $table->text('submission_text')->nullable(); // For theory/offline
            $table->string('attachment_path')->nullable(); // File upload path
            $table->enum('status', ['pending', 'submitted', 'graded'])->default('pending');
            $table->integer('score')->nullable();
            $table->text('teacher_comment')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            
            $table->unique(['assignment_id', 'student_id']);
            $table->index(['student_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_assignment_submissions');
    }
};
