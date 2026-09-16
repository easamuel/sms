<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_practice_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_session_id')->constrained('sms_practice_sessions')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('sms_students')->onDelete('cascade');
            $table->json('answers')->nullable();
            $table->integer('score')->default(0);
            $table->integer('total_questions')->default(0);
            $table->decimal('percentage', 5, 2)->default(0.00);
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['student_id', 'practice_session_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_practice_attempts');
    }
};
