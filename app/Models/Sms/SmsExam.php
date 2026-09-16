<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsExam extends Model
{
    protected $table = 'sms_exams';

    protected $fillable = [
        'school_id',
        'class_id',
        'subject_id',
        'teacher_id',
        'name',
        'title',
        'description',
        'exam_type',
        'exam_mode',
        'allow_manual_grading',
        'start_date',
        'end_date',
        'scheduled_date',
        'scheduled_time',
        'duration_minutes',
        'total_questions',
        'total_marks',
        'passing_marks',
        'passing_score',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_marks' => 'decimal:2',
            'passing_marks' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
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

    public function questions(): HasMany
    {
        return $this->hasMany(SmsExamQuestion::class, 'exam_id');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(SmsExamSession::class, 'exam_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(SmsExamResult::class, 'exam_id');
    }
}

