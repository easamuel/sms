<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sms_practice_attempts', function (Blueprint $table) {
            $table->json('selected_question_ids')->nullable()->after('total_questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sms_practice_attempts', function (Blueprint $table) {
            $table->dropColumn('selected_question_ids');
        });
    }
};
