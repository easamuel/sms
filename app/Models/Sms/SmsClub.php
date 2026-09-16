<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsClub extends Model
{
    protected $table = 'sms_clubs';
    
    protected $fillable = [
        'school_id',
        'name',
        'description',
        'category',
        'teacher_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(SmsTeacher::class, 'teacher_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(SmsStudent::class, 'club_id');
    }
}
