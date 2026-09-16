<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('message_threads')->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('sms_users')->onDelete('cascade');
            $table->enum('sender_type', ['admin', 'parent']); // Who sent it
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['thread_id', 'created_at']);
            $table->index(['sender_id', 'sender_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
