<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure role column has default value
        DB::statement("ALTER TABLE sms_users MODIFY COLUMN role ENUM('super-admin', 'admin', 'teacher', 'student', 'parent') NOT NULL DEFAULT 'student'");
    }

    public function down(): void
    {
        // Revert if needed
        DB::statement("ALTER TABLE sms_users MODIFY COLUMN role ENUM('super-admin', 'admin', 'teacher', 'student', 'parent') DEFAULT 'student'");
    }
};
