<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsExamSession extends Model
{
    protected $table = 'sms_exam_sessions';
    
    protected $fillable = [
        'exam_id',
        'student_id',
        'status',
        'started_at',
        'ended_at',
        'submitted_at',
        'time_remaining_seconds',
        'answers',
        'score',
        'total_score',
        'percentage',
        'passed',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'submitted_at' => 'datetime',
        'answers' => 'array',
        'time_remaining_seconds' => 'integer',
        'score' => 'integer',
        'total_score' => 'integer',
        'percentage' => 'decimal:2',
        'passed' => 'boolean',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(SmsExam::class, 'exam_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(SmsStudent::class, 'student_id');
    }
}
