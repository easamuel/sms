<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms_fee_payments', function (Blueprint $table) {
            // Gateway payment fields
            $table->string('gateway')->nullable()->after('payment_method'); // paystack, flutterwave, moniepoint, manual
            $table->string('gateway_reference')->nullable()->after('transaction_id');
            $table->enum('payment_status', ['pending', 'success', 'failed', 'cancelled'])->default('pending')->after('gateway_reference');
            $table->text('gateway_response')->nullable()->after('payment_status'); // JSON response from gateway
            $table->timestamp('verified_at')->nullable()->after('gateway_response');
            $table->foreignId('verified_by')->nullable()->constrained('sms_users')->onDelete('set null')->after('verified_at');
            
            // Receipt generation
            $table->string('receipt_number')->nullable()->after('verified_by');
            $table->boolean('receipt_generated')->default(false)->after('receipt_number');
            
            // Partial payment support
            $table->boolean('is_partial')->default(false)->after('receipt_generated');
            $table->decimal('partial_percentage', 5, 2)->nullable()->after('is_partial');
            
            // Indexes
            $table->index(['gateway_reference']);
            $table->index(['payment_status']);
            $table->index(['receipt_number']);
        });
    }

    public function down(): void
    {
        Schema::table('sms_fee_payments', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'gateway',
                'gateway_reference',
                'payment_status',
                'gateway_response',
                'verified_at',
                'verified_by',
                'receipt_number',
                'receipt_generated',
                'is_partial',
                'partial_percentage',
            ]);
        });
    }
};
