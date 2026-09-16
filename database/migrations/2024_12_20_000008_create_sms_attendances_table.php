<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('sms_students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('sms_classes')->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'late', 'excused'])->default('present');
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->unique(['student_id', 'class_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_attendances');
    }
};

