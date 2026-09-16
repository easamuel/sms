<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsAssignment extends Model
{
    protected $table = 'sms_assignments';
    
    protected $fillable = [
        'school_id',
        'teacher_id',
        'class_id',
        'subject_id',
        'title',
        'description',
        'submission_type',
        'due_date',
        'due_time',
        'total_marks',
        'is_active',
    ];

    protected $casts = [
        'due_date' => 'date',
        'due_time' => 'datetime',
        'total_marks' => 'integer',
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
        return $this->hasMany(SmsAssignmentQuestion::class, 'assignment_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(SmsAssignmentSubmission::class, 'assignment_id');
    }
}
