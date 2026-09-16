<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsSubject extends Model
{
    protected $table = 'sms_subjects';

    protected $fillable = [
        'school_id',
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SmsClass::class, 'sms_class_subjects', 'subject_id', 'class_id');
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(SmsTeacher::class, 'sms_teacher_subjects', 'subject_id', 'teacher_id');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(SmsExam::class, 'subject_id');
    }
}

