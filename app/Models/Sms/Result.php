<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    protected $table = 'sms_results';
    
    protected $fillable = [
        'school_id',
        'student_id',
        'class_id',
        'subject_id',
        'teacher_id',
        'academic_year',
        'term',
        'exam_type',
        'ca1_score',
        'ca2_score',
        'ca3_score',
        'ca_score',
        'exam_score',
        'total_score',
        'grade',
        'remark',
        'position',
        'teacher_comment',
    ];

    protected $casts = [
        'ca1_score' => 'decimal:2',
        'ca2_score' => 'decimal:2',
        'ca3_score' => 'decimal:2',
        'ca_score' => 'decimal:2',
        'exam_score' => 'decimal:2',
        'total_score' => 'decimal:2',
        'position' => 'integer',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically calculate total, grade, and remark before saving
        static::saving(function ($result) {
            // Calculate total score
            $result->total_score = ($result->ca_score ?? 0) + ($result->exam_score ?? 0);
            
            // Calculate grade if not set
            if (empty($result->grade)) {
                $result->grade = $result->calculateGrade();
            }
            
            // Calculate remark if not set
            if (empty($result->remark)) {
                $result->remark = $result->calculateRemark();
            }
        });
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(SmsStudent::class, 'student_id');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SmsClass::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(SmsSubject::class, 'subject_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(SmsTeacher::class, 'teacher_id');
    }

    // Calculate grade based on total score
    public function calculateGrade(): string
    {
        $score = $this->total_score;
        
        if ($score >= 75) return 'A';
        if ($score >= 70) return 'B';
        if ($score >= 65) return 'C';
        if ($score >= 60) return 'D';
        if ($score >= 50) return 'E';
        return 'F';
    }

    // Calculate remark based on grade
    public function calculateRemark(): string
    {
        $grade = $this->grade ?? $this->calculateGrade();
        
        return match($grade) {
            'A' => 'Excellent',
            'B' => 'Very Good',
            'C' => 'Good',
            'D' => 'Credit',
            'E' => 'Pass',
            default => 'Fail',
        };
    }
}
