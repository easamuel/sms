<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SmsStudent extends Model
{
    protected $table = 'sms_students';

    protected $fillable = [
        'school_id',
        'user_id',
        'student_id_number',
        'class_id',
        'club_id',
        'club_position',
        'admission_date',
        'date_of_birth',
        'gender',
        'photo',
        'address',
        'parent_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'admission_date' => 'date',
            'date_of_birth' => 'date',
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

    public function class(): BelongsTo
    {
        return $this->belongsTo(SmsClass::class, 'class_id');
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(SmsClub::class, 'club_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(SmsParent::class, 'parent_id');
    }

    public function attendances()
    {
        return $this->hasMany(SmsAttendance::class, 'student_id');
    }

    public function examResults()
    {
        return $this->hasMany(SmsExamResult::class, 'student_id');
    }

    public function feePayments()
    {
        return $this->hasMany(SmsFeePayment::class, 'student_id');
    }

    /**
     * Many-to-many relationship with parents (admin-controlled)
     */
    public function linkedParents()
    {
        return $this->belongsToMany(SmsParent::class, 'parent_student', 'student_id', 'parent_id')
            ->withPivot('relationship', 'created_by')
            ->withTimestamps();
    }
}

