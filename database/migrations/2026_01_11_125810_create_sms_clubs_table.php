<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_clubs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable(); // e.g., Academic, Sports, Arts, etc.
            $table->foreignId('teacher_id')->nullable()->constrained('sms_teachers')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['school_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_clubs');
    }
};
