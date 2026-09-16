<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsPracticeAttempt extends Model
{
    protected $table = 'sms_practice_attempts';
    
    protected $fillable = [
        'practice_session_id',
        'student_id',
        'answers',
        'score',
        'total_questions',
        'selected_question_ids',
        'percentage',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'selected_question_ids' => 'array',
        'score' => 'integer',
        'total_questions' => 'integer',
        'percentage' => 'decimal:2',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function practiceSession(): BelongsTo
    {
        return $this->belongsTo(SmsPracticeSession::class, 'practice_session_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(SmsStudent::class, 'student_id');
    }
}
