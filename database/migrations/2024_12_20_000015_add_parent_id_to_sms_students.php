<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms_students', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('sms_parents')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('sms_students', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
    }
};

