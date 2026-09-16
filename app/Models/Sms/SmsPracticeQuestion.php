<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsPracticeQuestion extends Model
{
    protected $table = 'sms_practice_questions';
    
    protected $fillable = [
        'practice_session_id',
        'question_text',
        'question_type',
        'options',
        'correct_answer',
        'explanation',
        'instructions',
        'marks',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'marks' => 'integer',
        'order' => 'integer',
    ];

    public function practiceSession(): BelongsTo
    {
        return $this->belongsTo(SmsPracticeSession::class, 'practice_session_id');
    }

    public function getOptionsAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return $decoded !== null ? $decoded : [];
        }
        return $value ?? [];
    }
}
