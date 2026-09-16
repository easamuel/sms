<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsSchool extends Model
{
    protected $table = 'sms_schools';

    protected $fillable = [
        'name',
        'registration_number',
        'school_type',
        'address',
        'city',
        'state',
        'country',
        'phone',
        'email',
        'website',
        'logo',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function students(): HasMany
    {
        return $this->hasMany(SmsStudent::class, 'school_id');
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(SmsTeacher::class, 'school_id');
    }

    public function classes(): HasMany
    {
        return $this->hasMany(SmsClass::class, 'school_id');
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(SmsSubject::class, 'school_id');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(SmsExam::class, 'school_id');
    }

    public function fees(): HasMany
    {
        return $this->hasMany(SmsFee::class, 'school_id');
    }

    public function notices(): HasMany
    {
        return $this->hasMany(SmsNotice::class, 'school_id');
    }
}

