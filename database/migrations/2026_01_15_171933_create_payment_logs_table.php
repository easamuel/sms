<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained('sms_fee_payments')->onDelete('set null');
            $table->foreignId('manual_transfer_id')->nullable()->constrained('manual_transfers')->onDelete('set null');
            
            $table->string('event_type'); // payment_initiated, payment_completed, webhook_received, etc.
            $table->string('gateway')->nullable(); // paystack, flutterwave, moniepoint, manual
            $table->string('transaction_reference')->nullable();
            $table->string('gateway_reference')->nullable();
            
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency', 3)->default('NGN');
            
            $table->enum('status', ['pending', 'success', 'failed', 'cancelled'])->default('pending');
            $table->text('request_data')->nullable(); // JSON
            $table->text('response_data')->nullable(); // JSON
            $table->text('error_message')->nullable();
            
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
            
            $table->index(['school_id', 'event_type']);
            $table->index(['transaction_reference']);
            $table->index(['gateway_reference']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};
