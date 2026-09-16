<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsFeePayment extends Model
{
    protected $table = 'sms_fee_payments';

    protected $fillable = [
        'school_id',
        'fee_id',
        'student_id',
        'student_fee_id', // Link to student_fees table
        'amount_paid',
        'payment_date',
        'payment_method',
        'transaction_id',
        'remarks',
        'gateway',
        'gateway_reference',
        'payment_status',
        'gateway_response',
        'verified_at',
        'verified_by',
        'receipt_number',
        'receipt_generated',
        'is_partial',
        'partial_percentage',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'payment_date' => 'date',
        'gateway_response' => 'array',
        'verified_at' => 'datetime',
        'receipt_generated' => 'boolean',
        'is_partial' => 'boolean',
        'partial_percentage' => 'decimal:2',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function fee(): BelongsTo
    {
        return $this->belongsTo(SmsFee::class, 'fee_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(SmsStudent::class, 'student_id');
    }

    public function studentFee(): BelongsTo
    {
        return $this->belongsTo(StudentFee::class, 'student_fee_id');
    }
}

