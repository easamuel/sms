<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SmsTeacher extends Model
{
    protected $table = 'sms_teachers';

    protected $fillable = [
        'school_id',
        'user_id',
        'employee_id',
        'teacher_type',
        'qualification',
        'specialization',
        'hire_date',
        'salary',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
            'salary' => 'decimal:2',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(SmsUser::class, 'user_id');
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SmsClass::class, 'sms_class_teachers', 'teacher_id', 'class_id');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(SmsSubject::class, 'sms_teacher_subjects', 'teacher_id', 'subject_id');
    }
}

