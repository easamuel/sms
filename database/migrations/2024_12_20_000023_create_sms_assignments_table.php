<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('sms_teachers')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('sms_classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('sms_subjects')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('submission_type', ['online', 'offline', 'both'])->default('online');
            $table->date('due_date');
            $table->time('due_time')->nullable();
            $table->integer('total_marks')->default(100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['teacher_id', 'class_id', 'subject_id']);
            $table->index(['class_id', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_assignments');
    }
};
