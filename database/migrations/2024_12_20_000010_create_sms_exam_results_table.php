<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('exam_id')->constrained('sms_exams')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('sms_students')->onDelete('cascade');
            $table->decimal('marks_obtained', 8, 2);
            $table->string('grade')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->unique(['exam_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_exam_results');
    }
};

