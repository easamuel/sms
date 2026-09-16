<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timetable extends Model
{
    protected $table = 'sms_timetables';
    
    protected $fillable = [
        'school_id',
        'class_id',
        'subject_id',
        'teacher_id',
        'day',
        'start_time',
        'end_time',
        'period_number',
        'academic_year',
        'term',
        'is_active',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

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
}
