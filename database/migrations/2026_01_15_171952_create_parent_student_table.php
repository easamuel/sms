<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('parent_student')) {
            Schema::dropIfExists('parent_student');
        }
        
        Schema::create('parent_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('sms_parents')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('sms_students')->onDelete('cascade');
            $table->enum('relationship', ['father', 'mother', 'guardian', 'other'])->default('father');
            
            // Admin who created this link
            $table->foreignId('created_by')->nullable()->constrained('sms_users')->onDelete('set null');
            
            $table->timestamps();
            
            // Ensure a parent-student relationship is unique
            $table->unique(['parent_id', 'student_id']);
            $table->index(['parent_id']);
            $table->index(['student_id']);
        });
        
        // Migrate existing parent_id from sms_students to parent_student pivot table
        // This preserves existing relationships
        DB::statement("
            INSERT INTO parent_student (parent_id, student_id, relationship, created_at, updated_at)
            SELECT parent_id, id, 'father', NOW(), NOW()
            FROM sms_students
            WHERE parent_id IS NOT NULL
            AND NOT EXISTS (
                SELECT 1 FROM parent_student ps 
                WHERE ps.parent_id = sms_students.parent_id 
                AND ps.student_id = sms_students.id
            )
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_student');
    }
};
