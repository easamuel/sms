<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('sms_users')->onDelete('cascade');
            $table->string('student_id_number')->unique();
            $table->foreignId('class_id')->nullable()->constrained('sms_classes')->onDelete('set null');
            $table->date('admission_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->text('address')->nullable();
            // parent_id will be added after parents table is created
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('status', ['active', 'inactive', 'graduated', 'transferred'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_students');
    }
};

