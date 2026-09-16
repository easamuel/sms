<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms_student_assessments', function (Blueprint $table) {
            $table->integer('no_of_times_present')->default(0)->after('sports_gaming');
            $table->integer('no_of_times_absent')->default(0)->after('no_of_times_present');
            $table->integer('no_of_times_late')->default(0)->after('no_of_times_absent');
            $table->text('teacher_remark')->nullable()->after('no_of_times_late');
        });
    }

    public function down(): void
    {
        Schema::table('sms_student_assessments', function (Blueprint $table) {
            $table->dropColumn(['no_of_times_present', 'no_of_times_absent', 'no_of_times_late', 'teacher_remark']);
        });
    }
};
