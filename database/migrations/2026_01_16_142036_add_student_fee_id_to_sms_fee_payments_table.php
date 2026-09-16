<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms_fee_payments', function (Blueprint $table) {
            // Add student_fee_id column if it doesn't exist
            if (!Schema::hasColumn('sms_fee_payments', 'student_fee_id')) {
                $table->foreignId('student_fee_id')->nullable()->after('student_id')->constrained('sms_student_fees')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sms_fee_payments', function (Blueprint $table) {
            if (Schema::hasColumn('sms_fee_payments', 'student_fee_id')) {
                $table->dropForeign(['student_fee_id']);
                $table->dropColumn('student_fee_id');
            }
        });
    }
};
