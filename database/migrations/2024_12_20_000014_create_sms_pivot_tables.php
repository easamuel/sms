<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Class-Teacher pivot
        Schema::create('sms_class_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('sms_classes')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('sms_teachers')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['class_id', 'teacher_id']);
        });

        // Teacher-Subject pivot
        Schema::create('sms_teacher_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('sms_teachers')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('sms_subjects')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['teacher_id', 'subject_id']);
        });

        // Class-Subject pivot
        Schema::create('sms_class_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('sms_classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('sms_subjects')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['class_id', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_class_subjects');
        Schema::dropIfExists('sms_teacher_subjects');
        Schema::dropIfExists('sms_class_teachers');
    }
};

