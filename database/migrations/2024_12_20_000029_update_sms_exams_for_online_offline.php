<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms_exams', function (Blueprint $table) {
            $table->enum('exam_mode', ['online', 'offline', 'both'])->default('online')->after('exam_type');
            $table->boolean('allow_manual_grading')->default(false)->after('exam_mode');
        });
    }

    public function down(): void
    {
        Schema::table('sms_exams', function (Blueprint $table) {
            $table->dropColumn(['exam_mode', 'allow_manual_grading']);
        });
    }
};
