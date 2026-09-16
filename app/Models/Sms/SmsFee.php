<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsFee extends Model
{
    protected $table = 'sms_fees';

    protected $fillable = [
        'school_id',
        'class_id',
        'name',
        'amount',
        'due_date',
        'academic_year',
        'is_active',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
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

    public function payments(): HasMany
    {
        return $this->hasMany(SmsFeePayment::class, 'fee_id');
    }
}

