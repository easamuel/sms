<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsParent extends Model
{
    protected $table = 'sms_parents';

    protected $fillable = [
        'school_id',
        'user_id',
        'occupation',
        'address',
        'phone',
        'relationship',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(SmsUser::class, 'user_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(SmsStudent::class, 'parent_id');
    }

    /**
     * Many-to-many relationship with students (admin-controlled)
     */
    public function linkedStudents()
    {
        return $this->belongsToMany(SmsStudent::class, 'parent_student', 'parent_id', 'student_id')
            ->withPivot('relationship', 'created_by')
            ->withTimestamps();
    }
}

