<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsExamQuestion extends Model
{
    protected $table = 'sms_exam_questions';
    
    protected $fillable = [
        'exam_id',
        'question_text',
        'question_type',
        'options',
        'correct_answer',
        'points',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'points' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the options attribute, ensuring it's always an array
     */
    public function getOptionsAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return $decoded !== null ? $decoded : [];
        }
        return $value ?? [];
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(SmsExam::class, 'exam_id');
    }
}
