<?php

namespace App\Models;

use App\Models\Sms\SmsParent;
use App\Models\Sms\SmsSchool;
use App\Models\Sms\SmsStudent;
use App\Models\Sms\SmsUser;
use App\Models\Sms\StudentFee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManualTransfer extends Model
{
    protected $fillable = [
        'school_id',
        'parent_id',
        'student_id',
        'student_fee_id',
        'amount',
        'bank_name',
        'account_name',
        'account_number',
        'transaction_reference',
        'proof_document',
        'notes',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(SmsParent::class, 'parent_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(SmsStudent::class, 'student_id');
    }

    public function studentFee(): BelongsTo
    {
        return $this->belongsTo(StudentFee::class, 'student_fee_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(SmsUser::class, 'approved_by');
    }

    /**
     * Approve the transfer and create payment
     */
    public function approve($approvedBy): bool
    {
        try {
            \DB::beginTransaction();

            $this->status = 'approved';
            $this->approved_by = $approvedBy->id;
            $this->approved_at = now();
            $this->save();

            // Create payment record
            if ($this->student_fee_id) {
                $studentFee = $this->studentFee;
                if ($studentFee) {
                    $payment = \App\Models\Sms\SmsFeePayment::create([
                        'school_id' => $this->school_id,
                        'fee_id' => $studentFee->fee_id,
                        'student_id' => $this->student_id,
                        'student_fee_id' => $this->student_fee_id,
                        'amount_paid' => $this->amount,
                        'payment_date' => now(),
                        'payment_method' => 'bank_transfer',
                        'gateway' => 'manual',
                        'payment_status' => 'success',
                        'transaction_id' => $this->transaction_reference,
                        'verified_at' => now(),
                        'verified_by' => $approvedBy->id,
                    ]);

                    // Update student fee balance
                    $studentFee->paid_amount += $this->amount;
                    $studentFee->balance = $studentFee->amount - $studentFee->paid_amount;
                    $studentFee->updateStatus();
                    $studentFee->save();
                }
            }

            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reject the transfer
     */
    public function reject($rejectedBy, $reason = null): void
    {
        $this->status = 'rejected';
        $this->approved_by = $rejectedBy->id;
        $this->rejection_reason = $reason;
        $this->save();
    }
}
