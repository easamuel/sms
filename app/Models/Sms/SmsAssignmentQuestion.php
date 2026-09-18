<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsAssignmentQuestion extends Model
{
    protected $table = 'sms_assignment_questions';
    
    protected $fillable = [
        'assignment_id',
        'question_text',
        'question_type',
        'options',
        'correct_answer',
        'instructions',
        'marks',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'marks' => 'integer',
        'order' => 'integer',
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(SmsAssignment::class, 'assignment_id');
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
