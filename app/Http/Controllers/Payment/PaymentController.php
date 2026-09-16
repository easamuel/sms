<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\SchoolPaymentSetting;
use App\Models\Sms\SmsFeePayment;
use App\Models\Sms\StudentFee;
use App\Models\Sms\SmsFee;
use App\Models\Sms\SmsStudent;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiate(Request $request)
    {
        $smsUser = session('sms_user');
        $smsRole = session('sms_role');

        if ($smsRole !== 'parent') {
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Access denied.');
        }

        // Handle both real StudentFee IDs and virtual fees (format: virtual_studentId_feeId)
        $studentFeeIdInput = $request->input('student_fee_id');
        $isVirtual = is_string($studentFeeIdInput) && str_starts_with($studentFeeIdInput, 'virtual_');
        
        $studentFee = null;
        $student = null;
        $fee = null;
        $school = null;
        
        if ($isVirtual) {
            // Parse virtual fee: virtual_studentId_feeId
            $parts = explode('_', $studentFeeIdInput);
            if (count($parts) >= 3) {
                $studentId = (int)$parts[1];
                $feeId = (int)$parts[2];
                
                $validated = $request->validate([
                    'amount' => 'required|numeric|min:0.01',
                    'payment_type' => 'required|in:full,partial',
                ]);
                
                // Get student and fee
                $student = SmsStudent::findOrFail($studentId);
                $fee = SmsFee::findOrFail($feeId);
                $school = $student->school;
                
                // Verify fee belongs to student's class
                if ($fee->class_id !== $student->class_id || $fee->school_id !== $student->school_id) {
                    return back()->with('error', 'Fee does not belong to this student\'s class.');
                }
                
                // Create or get StudentFee record for this virtual fee
                $studentFee = StudentFee::firstOrCreate(
                    [
                        'student_id' => $studentId,
                        'fee_id' => $feeId,
                    ],
                    [
                        'school_id' => $school->id,
                        'amount' => $fee->amount,
                        'paid_amount' => 0,
                        'balance' => $fee->amount,
                        'status' => 'pending',
                        'due_date' => $fee->due_date,
                    ]
                );
                
                // Recalculate balance based on existing payments
                $existingPayments = SmsFeePayment::where('student_id', $studentId)
                    ->where('fee_id', $feeId)
                    ->where('payment_status', 'completed')
                    ->sum('amount_paid');
                
                $studentFee->paid_amount = $existingPayments;
                $studentFee->balance = max(0, $fee->amount - $existingPayments);
                $studentFee->updateStatus();
                $studentFee->save();
            } else {
                return back()->with('error', 'Invalid fee information.');
            }
        } else {
            $validated = $request->validate([
                'student_fee_id' => 'required|exists:sms_student_fees,id',
                'amount' => 'required|numeric|min:0.01',
                'payment_type' => 'required|in:full,partial',
            ]);
            
            $studentFee = StudentFee::with(['student', 'fee'])->findOrFail($validated['student_fee_id']);
            $student = $studentFee->student;
            $fee = $studentFee->fee;
            $school = $studentFee->school;
        }

        // Verify parent has access to this student
        $parent = \App\Models\Sms\SmsParent::where('user_id', $smsUser->id)->first();
        if (!$parent) {
            return back()->with('error', 'Parent profile not found.');
        }

        // Check if parent is linked to student (many-to-many or old parent_id)
        $isLinkedViaParentId = ($student->parent_id === $parent->id);
        $isLinkedViaPivot = \DB::table('parent_student')
            ->where('parent_id', $parent->id)
            ->where('student_id', $student->id)
            ->exists();
        $isLinked = $isLinkedViaParentId || $isLinkedViaPivot;
        
        if (!$isLinked) {
            return back()->with('error', 'You do not have access to pay fees for this student.');
        }

        // Validate amount
        $paymentAmount = $validated['amount'] ?? $request->input('amount');
        $paymentType = $validated['payment_type'] ?? $request->input('payment_type', 'full');
        
        if ($paymentType === 'full') {
            if ($paymentAmount > $studentFee->balance) {
                return back()->with('error', 'Payment amount exceeds balance.');
            }
        } else {
            // Partial payment
            $settings = SchoolPaymentSetting::where('school_id', $school->id)->first();
            $minPercentage = $settings->minimum_payment_percentage ?? 0;
            $minAmount = ($studentFee->amount * $minPercentage) / 100;
            
            if ($paymentAmount < $minAmount) {
                return back()->with('error', "Minimum payment is ₦" . number_format($minAmount, 2) . " ({$minPercentage}%)");
            }
        }

        // Get payment settings
        $settings = SchoolPaymentSetting::where('school_id', $school->id)->first();
        if (!$settings || !$settings->getActiveGateway()) {
            return back()->with('error', 'Payment gateway not configured. Please contact the school administrator.');
        }

        try {
            DB::beginTransaction();

            // Create pending payment record
            $payment = SmsFeePayment::create([
                'school_id' => $school->id,
                'fee_id' => $studentFee->fee_id,
                'student_id' => $studentFee->student_id,
                'student_fee_id' => $studentFee->id,
                'amount_paid' => $paymentAmount,
                'payment_date' => now(),
                'payment_method' => 'online',
                'gateway' => $settings->getActiveGateway(),
                'payment_status' => 'pending',
                'is_partial' => $paymentType === 'partial',
                'partial_percentage' => $paymentType === 'partial' 
                    ? ($paymentAmount / $studentFee->amount) * 100 
                    : null,
            ]);

            // Initialize payment with gateway
            $gatewayService = new PaymentGatewayService($settings);
            $initResponse = $gatewayService->initializePayment([
                'amount' => $paymentAmount,
                'email' => $smsUser->email,
                'reference' => 'PAY-' . $payment->id . '-' . time(),
                'callback_url' => route('payment.callback'),
                'student_id' => $studentFee->student_id,
                'student_fee_id' => $studentFee->id,
                'name' => $smsUser->name,
            ]);

            // Update payment with gateway reference
            $payment->gateway_reference = $initResponse['reference'];
            $payment->transaction_id = $initResponse['reference'];
            $payment->save();

            DB::commit();

            // Redirect to payment gateway
            return redirect($initResponse['authorization_url']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference') ?? $request->input('tx_ref');
        
        if (!$reference) {
            return redirect()->route('sms.parent.fees')
                ->with('error', 'Payment reference not found.');
        }

        // Find payment by reference
        $payment = SmsFeePayment::where('gateway_reference', $reference)
            ->orWhere('transaction_id', $reference)
            ->first();

        if (!$payment) {
            return redirect()->route('sms.parent.fees')
                ->with('error', 'Payment not found.');
        }

        // Verify payment with gateway
        $settings = SchoolPaymentSetting::where('school_id', $payment->school_id)->first();
        if (!$settings) {
            return redirect()->route('sms.parent.fees')
                ->with('error', 'Payment settings not found.');
        }

        try {
            $gatewayService = new PaymentGatewayService($settings);
            $verification = $gatewayService->verifyPayment($reference);

            if ($verification['success']) {
                DB::beginTransaction();

                // Update payment
                $payment->payment_status = 'success';
                $payment->gateway_response = $verification['data'];
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

                DB::commit();

                return redirect()->route('sms.parent.fees')
                    ->with('success', 'Payment successful! Receipt will be generated.');
            } else {
                $payment->payment_status = 'failed';
                $payment->save();

                return redirect()->route('sms.parent.fees')
                    ->with('error', 'Payment verification failed.');
            }
        } catch (\Exception $e) {
            return redirect()->route('sms.parent.fees')
                ->with('error', 'Payment verification error: ' . $e->getMessage());
        }
    }
}
