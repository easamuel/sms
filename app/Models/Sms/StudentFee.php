<?php

namespace App\Models\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentFee extends Model
{
    protected $table = 'sms_student_fees';
    
    protected $fillable = [
        'school_id',
        'student_id',
        'fee_id',
        'amount',
        'paid_amount',
        'balance',
        'status',
        'due_date',
        'paid_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(SmsStudent::class, 'student_id');
    }

    public function fee(): BelongsTo
    {
        return $this->belongsTo(SmsFee::class, 'fee_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SmsFeePayment::class, 'student_fee_id');
    }

    // Update status based on payment
    public function updateStatus(): void
    {
        if ($this->balance <= 0) {
            $this->status = 'paid';
            $this->paid_date = now();
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial';
        } elseif ($this->due_date && $this->due_date < now()) {
            $this->status = 'overdue';
        } else {
            $this->status = 'pending';
        }
        
        $this->save();
    }
}
