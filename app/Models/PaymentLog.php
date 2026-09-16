<?php

namespace App\Models;

use App\Models\Sms\SmsSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentLog extends Model
{
    protected $fillable = [
        'school_id',
        'payment_id',
        'manual_transfer_id',
        'event_type',
        'gateway',
        'transaction_reference',
        'gateway_reference',
        'amount',
        'currency',
        'status',
        'request_data',
        'response_data',
        'error_message',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'request_data' => 'array',
        'response_data' => 'array',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Sms\SmsFeePayment::class, 'payment_id');
    }

    public function manualTransfer(): BelongsTo
    {
        return $this->belongsTo(ManualTransfer::class, 'manual_transfer_id');
    }

    /**
     * Log a payment event
     */
    public static function logEvent(array $data): self
    {
        return self::create([
            'school_id' => $data['school_id'] ?? null,
            'payment_id' => $data['payment_id'] ?? null,
            'manual_transfer_id' => $data['manual_transfer_id'] ?? null,
            'event_type' => $data['event_type'],
            'gateway' => $data['gateway'] ?? null,
            'transaction_reference' => $data['transaction_reference'] ?? null,
            'gateway_reference' => $data['gateway_reference'] ?? null,
            'amount' => $data['amount'] ?? null,
            'currency' => $data['currency'] ?? 'NGN',
            'status' => $data['status'] ?? 'pending',
            'request_data' => $data['request_data'] ?? null,
            'response_data' => $data['response_data'] ?? null,
            'error_message' => $data['error_message'] ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
