<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms_results', function (Blueprint $table) {
            // Add CA1, CA2, CA3 fields
            $table->decimal('ca1_score', 5, 2)->default(0)->after('exam_type');
            $table->decimal('ca2_score', 5, 2)->default(0)->after('ca1_score');
            $table->decimal('ca3_score', 5, 2)->default(0)->after('ca2_score');
            
            // Keep ca_score and exam_score for backward compatibility but make them nullable
            // They will be calculated from CA1+CA2+CA3 and Exam
        });
    }

    public function down(): void
    {
        Schema::table('sms_results', function (Blueprint $table) {
            $table->dropColumn(['ca1_score', 'ca2_score', 'ca3_score']);
        });
    }
};
