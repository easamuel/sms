<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_assignment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('sms_assignments')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('question_type', ['objective', 'theory', 'mixed'])->default('theory');
            $table->json('options')->nullable(); // For objective questions
            $table->string('correct_answer')->nullable(); // For objective questions
            $table->text('instructions')->nullable();
            $table->integer('marks');
            $table->integer('order')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_assignment_questions');
    }
};
