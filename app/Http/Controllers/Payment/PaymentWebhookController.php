<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\SchoolPaymentSetting;
use App\Models\Sms\SmsFeePayment;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request, $gateway = 'paystack')
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Paystack-Signature') 
                  ?? $request->header('verif-hash')
                  ?? null;

        // Get school from metadata or find by reference
        $reference = $request->input('data.reference') ?? $request->input('data.tx_ref');
        
        if (!$reference) {
            Log::warning('Webhook received without reference', ['gateway' => $gateway]);
            return response()->json(['status' => 'error', 'message' => 'No reference'], 400);
        }

        // Find payment to get school
        $payment = SmsFeePayment::where('gateway_reference', $reference)
            ->orWhere('transaction_id', $reference)
            ->first();

        if (!$payment) {
            Log::warning('Webhook payment not found', ['reference' => $reference]);
            return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
        }

        $settings = SchoolPaymentSetting::where('school_id', $payment->school_id)->first();
        if (!$settings) {
            Log::error('Payment settings not found for webhook', ['school_id' => $payment->school_id]);
            return response()->json(['status' => 'error', 'message' => 'Settings not found'], 500);
        }

        // Verify webhook signature
        $gatewayService = new PaymentGatewayService($settings);
        if ($signature && !$gatewayService->verifyWebhookSignature($payload, $signature)) {
            Log::warning('Webhook signature verification failed', ['gateway' => $gateway]);
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 401);
        }

        try {
            // Process webhook based on gateway
            switch ($gateway) {
                case 'paystack':
                    return $this->handlePaystackWebhook($request, $payment, $settings);
                case 'flutterwave':
                    return $this->handleFlutterwaveWebhook($request, $payment, $settings);
                default:
                    return response()->json(['status' => 'error', 'message' => 'Unknown gateway'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Webhook processing error', [
                'gateway' => $gateway,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    protected function handlePaystackWebhook(Request $request, $payment, $settings)
    {
        $event = $request->input('event');
        $data = $request->input('data');

        if ($event === 'charge.success') {
            DB::beginTransaction();

            try {
                // Update payment if not already verified
                if ($payment->payment_status !== 'success') {
                    $payment->payment_status = 'success';
                    $payment->gateway_response = $data;
                    $payment->verified_at = now();
                    $payment->save();

                    // Update student fee
                    $studentFee = $payment->studentFee;
                    if ($studentFee) {
                        $studentFee->paid_amount += $payment->amount_paid;
                        $studentFee->balance = $studentFee->amount - $studentFee->paid_amount;
                        $studentFee->updateStatus();
                        $studentFee->save();
                    }
                }

                DB::commit();

                \App\Models\PaymentLog::logEvent([
                    'school_id' => $payment->school_id,
                    'payment_id' => $payment->id,
                    'event_type' => 'webhook_received',
                    'gateway' => 'paystack',
                    'transaction_reference' => $data['reference'] ?? null,
                    'gateway_reference' => $data['reference'] ?? null,
                    'amount' => ($data['amount'] ?? 0) / 100,
                    'status' => 'success',
                    'response_data' => $data,
                ]);

                return response()->json(['status' => 'success'], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        return response()->json(['status' => 'ignored'], 200);
    }

    protected function handleFlutterwaveWebhook(Request $request, $payment, $settings)
    {
        $event = $request->input('event');
        $data = $request->input('data');

        if ($event === 'charge.completed' && ($data['status'] ?? '') === 'successful') {
            DB::beginTransaction();

            try {
                if ($payment->payment_status !== 'success') {
                    $payment->payment_status = 'success';
                    $payment->gateway_response = $data;
                    $payment->verified_at = now();
                    $payment->save();

                    $studentFee = $payment->studentFee;
                    if ($studentFee) {
                        $studentFee->paid_amount += $payment->amount_paid;
                        $studentFee->balance = $studentFee->amount - $studentFee->paid_amount;
                        $studentFee->updateStatus();
                        $studentFee->save();
                    }
                }

                DB::commit();

                \App\Models\PaymentLog::logEvent([
                    'school_id' => $payment->school_id,
                    'payment_id' => $payment->id,
                    'event_type' => 'webhook_received',
                    'gateway' => 'flutterwave',
                    'transaction_reference' => $data['tx_ref'] ?? null,
                    'gateway_reference' => $data['tx_ref'] ?? null,
                    'amount' => $data['amount'] ?? 0,
                    'status' => 'success',
                    'response_data' => $data,
                ]);

                return response()->json(['status' => 'success'], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        return response()->json(['status' => 'ignored'], 200);
    }
}
