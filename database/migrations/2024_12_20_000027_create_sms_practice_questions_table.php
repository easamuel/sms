<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_practice_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_session_id')->constrained('sms_practice_sessions')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('question_type', ['objective', 'theory', 'mixed'])->default('objective');
            $table->json('options')->nullable(); // For objective questions
            $table->string('correct_answer')->nullable(); // For objective questions
            $table->text('explanation')->nullable(); // Explanation shown after answer
            $table->text('instructions')->nullable();
            $table->integer('marks')->default(1);
            $table->integer('order')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_practice_questions');
    }
};
