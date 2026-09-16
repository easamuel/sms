<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->string('name');
            $table->string('section')->nullable();
            $table->string('academic_year');
            $table->integer('capacity')->nullable();
            $table->unsignedBigInteger('class_teacher_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_classes');
    }
};

