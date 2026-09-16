<?php

namespace App\Services;

use App\Models\SchoolPaymentSetting;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentGatewayService
{
    protected $settings;
    protected $gateway;

    public function __construct(SchoolPaymentSetting $settings)
    {
        $this->settings = $settings;
        $this->gateway = $settings->getActiveGateway();
    }

    /**
     * Initialize payment with gateway
     */
    public function initializePayment(array $data): array
    {
        $amount = $data['amount'] * 100; // Convert to kobo/cents
        $reference = $data['reference'] ?? $this->generateReference();
        $email = $data['email'];
        $callbackUrl = $data['callback_url'] ?? $this->settings->callback_url;

        PaymentLog::logEvent([
            'school_id' => $this->settings->school_id,
            'event_type' => 'payment_initiated',
            'gateway' => $this->gateway,
            'transaction_reference' => $reference,
            'amount' => $data['amount'],
            'currency' => $this->settings->currency,
            'status' => 'pending',
            'request_data' => $data,
        ]);

        try {
            switch ($this->gateway) {
                case 'paystack':
                    return $this->initializePaystack($amount, $email, $reference, $callbackUrl, $data);
                case 'flutterwave':
                    return $this->initializeFlutterwave($amount, $email, $reference, $callbackUrl, $data);
                case 'moniepoint':
                    return $this->initializeMoniepoint($amount, $email, $reference, $callbackUrl, $data);
                default:
                    throw new \Exception('No active payment gateway configured');
            }
        } catch (\Exception $e) {
            PaymentLog::logEvent([
                'school_id' => $this->settings->school_id,
                'event_type' => 'payment_initiated',
                'gateway' => $this->gateway,
                'transaction_reference' => $reference,
                'amount' => $data['amount'],
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Initialize Paystack payment
     */
    protected function initializePaystack($amount, $email, $reference, $callbackUrl, $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->settings->paystack_secret_key,
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transaction/initialize', [
            'email' => $email,
            'amount' => $amount,
            'reference' => $reference,
            'callback_url' => $callbackUrl,
            'metadata' => [
                'student_id' => $data['student_id'] ?? null,
                'student_fee_id' => $data['student_fee_id'] ?? null,
                'school_id' => $this->settings->school_id,
            ],
        ]);

        $responseData = $response->json();

        PaymentLog::logEvent([
            'school_id' => $this->settings->school_id,
            'event_type' => 'payment_initiated',
            'gateway' => 'paystack',
            'transaction_reference' => $reference,
            'gateway_reference' => $responseData['data']['reference'] ?? null,
            'amount' => $data['amount'],
            'status' => $response->successful() ? 'success' : 'failed',
            'request_data' => ['email' => $email, 'amount' => $amount, 'reference' => $reference],
            'response_data' => $responseData,
            'error_message' => $response->successful() ? null : ($responseData['message'] ?? 'Payment initialization failed'),
        ]);

        if (!$response->successful()) {
            throw new \Exception($responseData['message'] ?? 'Payment initialization failed');
        }

        return [
            'authorization_url' => $responseData['data']['authorization_url'],
            'access_code' => $responseData['data']['access_code'],
            'reference' => $reference,
        ];
    }

    /**
     * Initialize Flutterwave payment
     */
    protected function initializeFlutterwave($amount, $email, $reference, $callbackUrl, $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->settings->flutterwave_secret_key,
            'Content-Type' => 'application/json',
        ])->post('https://api.flutterwave.com/v3/payments', [
            'tx_ref' => $reference,
            'amount' => $data['amount'],
            'currency' => $this->settings->currency,
            'redirect_url' => $callbackUrl,
            'payment_options' => 'card,account,banktransfer,ussd',
            'customer' => [
                'email' => $email,
                'name' => $data['name'] ?? 'Parent',
            ],
            'meta' => [
                'student_id' => $data['student_id'] ?? null,
                'student_fee_id' => $data['student_fee_id'] ?? null,
                'school_id' => $this->settings->school_id,
            ],
        ]);

        $responseData = $response->json();

        PaymentLog::logEvent([
            'school_id' => $this->settings->school_id,
            'event_type' => 'payment_initiated',
            'gateway' => 'flutterwave',
            'transaction_reference' => $reference,
            'gateway_reference' => $responseData['data']['tx_ref'] ?? null,
            'amount' => $data['amount'],
            'status' => $response->successful() ? 'success' : 'failed',
            'request_data' => ['email' => $email, 'amount' => $data['amount'], 'reference' => $reference],
            'response_data' => $responseData,
            'error_message' => $response->successful() ? null : ($responseData['message'] ?? 'Payment initialization failed'),
        ]);

        if (!$response->successful() || $responseData['status'] !== 'success') {
            throw new \Exception($responseData['message'] ?? 'Payment initialization failed');
        }

        return [
            'authorization_url' => $responseData['data']['link'],
            'reference' => $reference,
        ];
    }

    /**
     * Initialize Moniepoint payment (placeholder - implement when API available)
     */
    protected function initializeMoniepoint($amount, $email, $reference, $callbackUrl, $data): array
    {
        // TODO: Implement Moniepoint API when available
        throw new \Exception('Moniepoint integration not yet available');
    }

    /**
     * Verify payment with gateway
     */
    public function verifyPayment(string $reference): array
    {
        try {
            switch ($this->gateway) {
                case 'paystack':
                    return $this->verifyPaystack($reference);
                case 'flutterwave':
                    return $this->verifyFlutterwave($reference);
                case 'moniepoint':
                    return $this->verifyMoniepoint($reference);
                default:
                    throw new \Exception('No active payment gateway configured');
            }
        } catch (\Exception $e) {
            PaymentLog::logEvent([
                'school_id' => $this->settings->school_id,
                'event_type' => 'payment_verification',
                'gateway' => $this->gateway,
                'transaction_reference' => $reference,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Verify Paystack payment
     */
    protected function verifyPaystack(string $reference): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->settings->paystack_secret_key,
            'Content-Type' => 'application/json',
        ])->get("https://api.paystack.co/transaction/verify/{$reference}");

        $responseData = $response->json();

        $status = $response->successful() && ($responseData['data']['status'] === 'success') ? 'success' : 'failed';

        PaymentLog::logEvent([
            'school_id' => $this->settings->school_id,
            'event_type' => 'payment_verification',
            'gateway' => 'paystack',
            'transaction_reference' => $reference,
            'gateway_reference' => $responseData['data']['reference'] ?? null,
            'amount' => ($responseData['data']['amount'] ?? 0) / 100,
            'status' => $status,
            'response_data' => $responseData,
        ]);

        return [
            'success' => $status === 'success',
            'amount' => ($responseData['data']['amount'] ?? 0) / 100,
            'currency' => $responseData['data']['currency'] ?? 'NGN',
            'gateway_reference' => $responseData['data']['reference'] ?? null,
            'paid_at' => $responseData['data']['paid_at'] ?? null,
            'data' => $responseData['data'] ?? [],
        ];
    }

    /**
     * Verify Flutterwave payment
     */
    protected function verifyFlutterwave(string $reference): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->settings->flutterwave_secret_key,
            'Content-Type' => 'application/json',
        ])->get("https://api.flutterwave.com/v3/transactions/{$reference}/verify");

        $responseData = $response->json();

        $status = $response->successful() && ($responseData['data']['status'] === 'successful') ? 'success' : 'failed';

        PaymentLog::logEvent([
            'school_id' => $this->settings->school_id,
            'event_type' => 'payment_verification',
            'gateway' => 'flutterwave',
            'transaction_reference' => $reference,
            'gateway_reference' => $responseData['data']['tx_ref'] ?? null,
            'amount' => $responseData['data']['amount'] ?? 0,
            'status' => $status,
            'response_data' => $responseData,
        ]);

        return [
            'success' => $status === 'success',
            'amount' => $responseData['data']['amount'] ?? 0,
            'currency' => $responseData['data']['currency'] ?? 'NGN',
            'gateway_reference' => $responseData['data']['tx_ref'] ?? null,
            'paid_at' => $responseData['data']['created_at'] ?? null,
            'data' => $responseData['data'] ?? [],
        ];
    }

    /**
     * Verify Moniepoint payment (placeholder)
     */
    protected function verifyMoniepoint(string $reference): array
    {
        throw new \Exception('Moniepoint integration not yet available');
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        if (!$this->settings->webhook_secret) {
            return false;
        }

        switch ($this->gateway) {
            case 'paystack':
                $hash = hash_hmac('sha512', $payload, $this->settings->webhook_secret);
                return hash_equals($hash, $signature);
            case 'flutterwave':
                $hash = hash_hmac('sha256', $payload, $this->settings->webhook_secret);
                return hash_equals($hash, $signature);
            default:
                return false;
        }
    }

    /**
     * Generate unique reference
     */
    protected function generateReference(): string
    {
        return 'TXN-' . time() . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
    }
}
