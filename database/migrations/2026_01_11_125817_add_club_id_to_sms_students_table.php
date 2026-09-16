<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms_students', function (Blueprint $table) {
            $table->foreignId('club_id')->nullable()->after('class_id')->constrained('sms_clubs')->onDelete('set null');
            $table->string('club_position')->nullable()->after('club_id'); // e.g., Member, Captain, Secretary, etc.
        });
    }

    public function down(): void
    {
        Schema::table('sms_students', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
            $table->dropColumn(['club_id', 'club_position']);
        });
    }
};
