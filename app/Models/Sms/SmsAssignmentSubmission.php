<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsAssignmentSubmission extends Model
{
    protected $table = 'sms_assignment_submissions';
    
    protected $fillable = [
        'assignment_id',
        'student_id',
        'submission_type',
        'answers',
        'submission_text',
        'attachment_path',
        'status',
        'score',
        'teacher_comment',
        'submitted_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'score' => 'integer',
        'submitted_at' => 'datetime',
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(SmsAssignment::class, 'assignment_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(SmsStudent::class, 'student_id');
    }
}
