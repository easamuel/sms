<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_student_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('sms_students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('sms_classes')->onDelete('cascade');
            $table->string('academic_year');
            $table->string('term'); // First Term, Second Term, Third Term
            $table->foreignId('teacher_id')->nullable()->constrained('sms_teachers')->onDelete('set null');
            
            // Affective Domain (1-4 rating)
            $table->integer('punctuality')->default(4);
            $table->integer('honesty')->default(4);
            $table->integer('neatness')->default(4);
            $table->integer('politeness')->default(4);
            $table->integer('obedience')->default(4);
            $table->integer('self_control')->default(4);
            $table->integer('relationship_with_others')->default(4);
            
            // Psychomotor Skills (1-4 rating)
            $table->integer('handling_of_tools')->default(4);
            $table->integer('drawing_painting')->default(4);
            $table->integer('handwriting')->default(4);
            $table->integer('musical_skill')->default(4);
            $table->integer('public_speaking')->default(4);
            $table->integer('sports_gaming')->default(4);
            
            $table->timestamps();
            
            $table->unique(['student_id', 'academic_year', 'term'], 'student_assessment_unique');
            $table->index(['school_id', 'class_id', 'academic_year', 'term'], 'assessments_school_class_year_term_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_student_assessments');
    }
};
