<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('sms_users')->onDelete('cascade');
            $table->string('occupation')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('relationship')->default('parent'); // parent, guardian
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_parents');
    }
};

