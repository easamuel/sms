<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsExamResult extends Model
{
    protected $table = 'sms_exam_results';

    protected $fillable = [
        'school_id',
        'exam_id',
        'student_id',
        'marks_obtained',
        'grade',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'marks_obtained' => 'decimal:2',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(SmsExam::class, 'exam_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(SmsStudent::class, 'student_id');
    }
}

