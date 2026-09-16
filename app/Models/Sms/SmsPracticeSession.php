<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsPracticeSession extends Model
{
    protected $table = 'sms_practice_sessions';
    
    protected $fillable = [
        'school_id',
        'teacher_id',
        'class_id',
        'subject_id',
        'title',
        'description',
        'availability',
        'start_date',
        'end_date',
        'show_answers_immediately',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'show_answers_immediately' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(SmsTeacher::class, 'teacher_id');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SmsClass::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(SmsSubject::class, 'subject_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(SmsPracticeQuestion::class, 'practice_session_id');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(SmsPracticeAttempt::class, 'practice_session_id');
    }
}
