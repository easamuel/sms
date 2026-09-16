<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsAttendance extends Model
{
    protected $table = 'sms_attendances';

    protected $fillable = [
        'school_id',
        'student_id',
        'class_id',
        'date',
        'status', // present, absent, late, excused
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(SmsStudent::class, 'student_id');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SmsClass::class, 'class_id');
    }
}

