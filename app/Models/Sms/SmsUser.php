<?php

namespace App\Models\Sms;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SmsUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'sms_users';
    
    protected $guard = 'web'; // Use default guard, but we'll use session-based auth

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'school_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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

    public function studentProfile(): HasOne
    {
        return $this->hasOne(SmsStudent::class, 'user_id');
    }

    public function teacherProfile(): HasOne
    {
        return $this->hasOne(SmsTeacher::class, 'user_id');
    }

    public function parentProfile(): HasOne
    {
        return $this->hasOne(SmsParent::class, 'user_id');
    }
}

