<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms_teachers', function (Blueprint $table) {
            $table->enum('teacher_type', ['primary', 'secondary'])->default('secondary')->after('employee_id');
        });
    }

    public function down(): void
    {
        Schema::table('sms_teachers', function (Blueprint $table) {
            $table->dropColumn('teacher_type');
        });
    }
};
