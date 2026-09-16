<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms_exams', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable()->after('subject_id')->constrained('sms_teachers')->onDelete('set null');
            $table->string('title')->nullable()->after('name'); // More descriptive than just 'name'
            $table->text('description')->nullable()->after('title');
            $table->integer('duration_minutes')->default(60)->after('end_date');
            $table->integer('total_questions')->default(0)->after('duration_minutes');
            $table->decimal('passing_score', 5, 2)->default(50)->after('total_questions');
            $table->timestamp('scheduled_date')->nullable()->after('end_date');
            $table->time('scheduled_time')->nullable()->after('scheduled_date');
        });
    }

    public function down(): void
    {
        Schema::table('sms_exams', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn([
                'teacher_id',
                'title',
                'description',
                'duration_minutes',
                'total_questions',
                'passing_score',
                'scheduled_date',
                'scheduled_time',
            ]);
        });
    }
};
