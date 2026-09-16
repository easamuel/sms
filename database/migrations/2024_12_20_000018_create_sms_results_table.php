<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('sms_students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('sms_classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('sms_subjects')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('sms_teachers')->onDelete('cascade');
            $table->string('academic_year');
            $table->string('term'); // First Term, Second Term, Third Term
            $table->string('exam_type'); // CA1, CA2, Test, Exam
            $table->decimal('ca_score', 5, 2)->default(0); // Continuous Assessment
            $table->decimal('exam_score', 5, 2)->default(0); // Examination Score
            $table->decimal('total_score', 5, 2)->default(0); // CA + Exam
            $table->string('grade')->nullable(); // A, B, C, D, F
            $table->string('remark')->nullable(); // Excellent, Very Good, Good, Pass, Fail
            $table->integer('position')->nullable(); // Position in class for this subject
            $table->text('teacher_comment')->nullable();
            $table->timestamps();
            
            // Add indexes first, then unique constraint
            $table->index(['student_id', 'academic_year', 'term']);
            $table->index(['class_id', 'subject_id', 'academic_year', 'term']);
        });
        
        // Add unique constraint after table is created
        Schema::table('sms_results', function (Blueprint $table) {
            $table->unique(['student_id', 'subject_id', 'academic_year', 'term', 'exam_type'], 'sms_results_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_results');
    }
};
