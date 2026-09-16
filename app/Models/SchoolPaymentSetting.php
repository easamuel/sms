<?php

namespace App\Models;

use App\Models\Sms\SmsSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolPaymentSetting extends Model
{
    protected $fillable = [
        'school_id',
        'paystack_public_key',
        'paystack_secret_key',
        'paystack_enabled',
        'flutterwave_public_key',
        'flutterwave_secret_key',
        'flutterwave_enabled',
        'moniepoint_api_key',
        'moniepoint_secret_key',
        'moniepoint_enabled',
        'callback_url',
        'webhook_secret',
        'currency',
        'minimum_payment_percentage',
        'bank_name',
        'account_name',
        'account_number',
        'transfer_instructions',
        'narration_format',
    ];

    protected $casts = [
        'paystack_enabled' => 'boolean',
        'flutterwave_enabled' => 'boolean',
        'moniepoint_enabled' => 'boolean',
        'minimum_payment_percentage' => 'decimal:2',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(SmsSchool::class, 'school_id');
    }

    /**
     * Get active gateway
     */
    public function getActiveGateway(): ?string
    {
        if ($this->paystack_enabled && $this->paystack_public_key && $this->paystack_secret_key) {
            return 'paystack';
        }
        if ($this->flutterwave_enabled && $this->flutterwave_public_key && $this->flutterwave_secret_key) {
            return 'flutterwave';
        }
        if ($this->moniepoint_enabled && $this->moniepoint_api_key && $this->moniepoint_secret_key) {
            return 'moniepoint';
        }
        return null;
    }
}
