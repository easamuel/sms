<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SmsClass extends Model
{
    protected $table = 'sms_classes';

    protected $fillable = [
        'school_id',
        'name',
        'section',
        'academic_year',
        'capacity',
        'class_teacher_id',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function classTeacher(): BelongsTo
    {
        return $this->belongsTo(SmsTeacher::class, 'class_teacher_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(SmsStudent::class, 'class_id');
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(SmsTeacher::class, 'sms_class_teachers', 'class_id', 'teacher_id');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(SmsSubject::class, 'sms_class_subjects', 'class_id', 'subject_id');
    }
}

