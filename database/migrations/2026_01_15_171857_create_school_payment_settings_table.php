<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_payment_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('sms_schools')->onDelete('cascade')->unique();
            
            // Paystack Settings
            $table->string('paystack_public_key')->nullable();
            $table->string('paystack_secret_key')->nullable();
            $table->boolean('paystack_enabled')->default(false);
            
            // Flutterwave Settings
            $table->string('flutterwave_public_key')->nullable();
            $table->string('flutterwave_secret_key')->nullable();
            $table->boolean('flutterwave_enabled')->default(false);
            
            // Moniepoint Settings (if available)
            $table->string('moniepoint_api_key')->nullable();
            $table->string('moniepoint_secret_key')->nullable();
            $table->boolean('moniepoint_enabled')->default(false);
            
            // General Settings
            $table->string('callback_url')->nullable();
            $table->string('webhook_secret')->nullable();
            $table->string('currency', 3)->default('NGN');
            $table->decimal('minimum_payment_percentage', 5, 2)->default(0.00); // e.g. 50.00 for 50%
            
            // Manual Bank Transfer Settings
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->text('transfer_instructions')->nullable();
            $table->string('narration_format')->nullable(); // e.g. "STU-{student_id}-{class}"
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_payment_settings');
    }
};
