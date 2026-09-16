<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('sms_users')->onDelete('cascade'); // Admin user
            $table->foreignId('parent_id')->constrained('sms_parents')->onDelete('cascade');
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
            
            // Ensure one thread per admin-parent pair
            $table->unique(['admin_id', 'parent_id']);
            $table->index(['school_id', 'admin_id']);
            $table->index(['school_id', 'parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_threads');
    }
};
