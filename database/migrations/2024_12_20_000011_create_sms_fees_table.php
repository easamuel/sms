<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('sms_classes')->onDelete('cascade');
            $table->string('name');
            $table->decimal('amount', 10, 2);
            $table->date('due_date')->nullable();
            $table->string('academic_year');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_fees');
    }
};

