<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\Sms\StudentFee;
use App\Models\Sms\SmsFeePayment;
use App\Models\Sms\SmsFee;
use App\Models\Sms\SmsStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsFeePaymentController extends Controller
{
    /**
     * Show fee payment page for parent
     */
    public function index()
    {
        $smsUser = session('sms_user');
        $smsRole = session('sms_role');
        $schoolId = $smsUser->school_id ?? null;

        if ($smsRole !== 'parent') {
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Access denied.');
        }

        // Get parent's children (both old parent_id and new many-to-many)
        $parent = \App\Models\Sms\SmsParent::where('user_id', $smsUser->id)->first();
        
        if (!$parent) {
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Parent profile not found.');
        }

        // CRITICAL: Use parent's school_id (authoritative source)
        $parentSchoolId = $parent->school_id ?? $schoolId;

        // Get students via old parent_id (MAX 2)
        $childrenOld = \App\Models\Sms\SmsStudent::where('parent_id', $parent->id)
            ->where('school_id', $parentSchoolId)
            ->with(['class', 'user'])
            ->limit(2)
            ->get();

        // Get students via many-to-many relationship (ONLY assigned by admin, MAX 2)
        $childrenLinked = $parent->linkedStudents()
            ->where('sms_students.school_id', $parentSchoolId)
            ->with(['class', 'user'])
            ->limit(2)
            ->get();

        // Merge and get unique students - ONLY show children actually assigned to this parent
        $children = $childrenOld->merge($childrenLinked)->unique('id');
        
        // CRITICAL: Enforce 2-child maximum
        $children = $children->take(2);

        // Get fees ONLY for children linked to this parent (max 2 children)
        $childrenIds = $children->pluck('id')->toArray();
        
        if (empty($childrenIds)) {
            $studentFees = collect();
            $feesByChild = collect();
        } else {
            // Get students with their classes
            $students = \App\Models\Sms\SmsStudent::whereIn('id', $childrenIds)
                ->with(['class', 'user'])
                ->get();
            
            $studentFees = collect();
            $feesByChild = collect();
            
            foreach ($students as $student) {
                // First, try to get fees from StudentFee table (if fees have been assigned)
                $assignedFees = StudentFee::where('student_id', $student->id)
                    ->with(['fee', 'payments'])
                    ->orderBy('due_date')
                    ->get();
                
                $studentFeeList = collect();
                
                if ($assignedFees->count() > 0) {
                    // Fees exist in StudentFee table - use them
                    foreach ($assignedFees as $fee) {
                        $fee->student = $student; // Attach student for easier access
                        $studentFeeList->push($fee);
                        $studentFees->push($fee);
                    }
                } else {
                    // No fees in StudentFee table - create virtual fees from SmsFee table based on class
                    if ($student->class_id) {
                        $classFees = \App\Models\Sms\SmsFee::where('class_id', $student->class_id)
                            ->where('school_id', $student->school_id)
                            ->where('is_active', true)
                            ->get();
                        
                        foreach ($classFees as $classFee) {
                            // Get payments for this fee (only completed payments)
                            $payments = SmsFeePayment::where('student_id', $student->id)
                                ->where('fee_id', $classFee->id)
                                ->where('payment_status', 'completed')
                                ->get();
                            
                            $totalPaid = $payments->sum('amount_paid');
                            // Balance doesn't include pending transfers (they're shown separately in transaction history)
                            // Balance = fee amount - completed payments only
                            $balance = max(0, $classFee->amount - $totalPaid);
                            
                            // Create a virtual StudentFee object for display
                            $virtualFee = new StudentFee();
                            $virtualFee->setRawAttributes([
                                'id' => 'virtual_' . $student->id . '_' . $classFee->id, // Virtual ID for reference
                                'student_id' => $student->id,
                                'fee_id' => $classFee->id, // CRITICAL: Ensure fee_id is set as attribute
                                'amount' => $classFee->amount,
                                'paid_amount' => $totalPaid,
                                'balance' => $balance,
                                'status' => $balance <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'pending'),
                                'due_date' => $classFee->due_date,
                            ]);
                            $virtualFee->exists = false; // Mark as non-persisted
                            $virtualFee->student = $student;
                            $virtualFee->setRelation('fee', $classFee); // Use setRelation to ensure it's properly set
                            $virtualFee->setRelation('payments', $payments);
                            
                            $studentFeeList->push($virtualFee);
                            $studentFees->push($virtualFee);
                        }
                    }
                }
                
                // Check for pending manual transfers for this student
                $pendingTransfers = \App\Models\ManualTransfer::where('student_id', $student->id)
                    ->where('status', 'pending')
                    ->get();
                
                // Group fees by child
                if ($studentFeeList->count() > 0) {
                    $totalBalance = $studentFeeList->sum(function($fee) {
                        $balance = $fee->amount - $fee->paid_amount;
                        return $balance > 0 ? $balance : 0;
                    });
                    
                    // Check if there's a pending transfer for this student
                    $hasPendingTransfer = $pendingTransfers->count() > 0;
                    
                    $feesByChild->put($student->id, [
                        'student' => $student,
                        'fees' => $studentFeeList,
                        'total_amount' => $studentFeeList->sum('amount'),
                        'total_paid' => $studentFeeList->sum('paid_amount'),
                        'total_balance' => $totalBalance,
                        'has_pending_transfer' => $hasPendingTransfer,
                        'pending_transfers' => $pendingTransfers,
                    ]);
                }
            }
        }

        // CRITICAL: ONE SYSTEM - Get payment settings from ANY school (since it's one system)
        // Try parent's school first, then try any school, since it's all the same system
        $paymentSettings = \App\Models\SchoolPaymentSetting::where('school_id', $parentSchoolId)->first();
        
        // If not found, get ANY payment settings (ONE SYSTEM = same settings for all)
        if (!$paymentSettings) {
            $paymentSettings = \App\Models\SchoolPaymentSetting::first();
            
            if ($paymentSettings) {
                \Log::info('Using payment settings from different school (ONE SYSTEM)', [
                    'parent_school_id' => $parentSchoolId,
                    'settings_school_id' => $paymentSettings->school_id,
                ]);
            }
        }
        
        // If still not found, create empty one to prevent errors
        if (!$paymentSettings) {
            \Log::warning('No payment settings found in system', [
                'parent_id' => $parent->id,
                'parent_school_id' => $parentSchoolId,
                'user_school_id' => $schoolId
            ]);
            
            // Create default payment settings (empty, but prevents null errors)
            $paymentSettings = new \App\Models\SchoolPaymentSetting();
            $paymentSettings->school_id = $parentSchoolId;
            $paymentSettings->currency = 'NGN';
            $paymentSettings->minimum_payment_percentage = 0;
        } else {
            // CRITICAL: Get fresh data directly from database to ensure we have latest values
            // Query directly from DB to bypass any Eloquent caching issues
            $dbSettings = \DB::table('school_payment_settings')
                ->where('id', $paymentSettings->id)
                ->first();
            
            if ($dbSettings) {
                // Use setRawAttributes to set all attributes directly from database
                // This bypasses any Eloquent caching or mutator issues
                $paymentSettings->setRawAttributes((array) $dbSettings);
                $paymentSettings->exists = true;
                $paymentSettings->syncOriginal();
            }
            
            // Debug: Log payment settings found with actual values
            \Log::info('Payment settings retrieved', [
                'settings_id' => $paymentSettings->id,
                'settings_school_id' => $paymentSettings->school_id,
                'parent_school_id' => $parentSchoolId,
                'has_account_number' => !empty($paymentSettings->account_number),
                'has_bank_name' => !empty($paymentSettings->bank_name),
                'has_account_name' => !empty($paymentSettings->account_name),
                'account_number' => $paymentSettings->account_number ? 'SET (' . strlen($paymentSettings->account_number) . ' chars): ' . substr($paymentSettings->account_number, 0, 4) . '...' : 'EMPTY',
                'bank_name' => $paymentSettings->bank_name ?: 'EMPTY',
                'account_name' => $paymentSettings->account_name ?: 'EMPTY',
                'account_name_db' => $dbSettings->account_name ?? 'NULL_IN_DB',
                'account_name_match' => ($paymentSettings->account_name === ($dbSettings->account_name ?? null)) ? 'MATCH' : 'MISMATCH',
            ]);
        }

        // Calculate totals - handle both StudentFee table and virtual fees from SmsFee table
        $totalFees = $studentFees->sum('amount');
        $totalPaid = $studentFees->sum('paid_amount');
        // Calculate balance dynamically: amount - paid_amount (never use stored balance field)
        $totalBalance = $studentFees->sum(function($fee) {
            $calculatedBalance = $fee->amount - $fee->paid_amount;
            return max(0, $calculatedBalance); // Never negative
        });
        
        // Ensure consistency: Recalculate balance for each fee
        foreach ($studentFees as $fee) {
            $fee->balance = max(0, $fee->amount - $fee->paid_amount);
        }

        // Get transaction history for all children
        $childrenIds = $children->pluck('id')->toArray();
        $transactionHistory = collect();
        
        if (!empty($childrenIds)) {
            // Get all completed payments
            $completedPayments = SmsFeePayment::whereIn('student_id', $childrenIds)
                ->where('payment_status', 'completed')
                ->with(['student.user', 'student.class', 'fee', 'studentFee'])
                ->orderBy('payment_date', 'desc')
                ->get();
            
            // Get all pending manual transfers
            $pendingTransfers = \App\Models\ManualTransfer::whereIn('student_id', $childrenIds)
                ->where('status', 'pending')
                ->with(['student.user', 'student.class', 'studentFee.fee'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Get all approved/rejected manual transfers
            $processedTransfers = \App\Models\ManualTransfer::whereIn('student_id', $childrenIds)
                ->whereIn('status', ['approved', 'rejected'])
                ->with(['student.user', 'student.class', 'studentFee.fee', 'approvedBy'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Combine all transactions
            foreach ($completedPayments as $payment) {
                $transactionHistory->push([
                    'type' => 'payment',
                    'data' => $payment,
                    'date' => $payment->payment_date ?? $payment->created_at,
                    'amount' => $payment->amount_paid,
                    'status' => 'completed',
                    'method' => $payment->payment_method ?? 'online',
                ]);
            }
            
            foreach ($pendingTransfers as $transfer) {
                $transactionHistory->push([
                    'type' => 'manual_transfer',
                    'data' => $transfer,
                    'date' => $transfer->created_at,
                    'amount' => $transfer->amount,
                    'status' => 'pending',
                    'method' => 'bank_transfer',
                ]);
            }
            
            foreach ($processedTransfers as $transfer) {
                $transactionHistory->push([
                    'type' => 'manual_transfer',
                    'data' => $transfer,
                    'date' => $transfer->approved_at ?? $transfer->created_at,
                    'amount' => $transfer->amount,
                    'status' => $transfer->status, // 'approved' or 'rejected'
                    'method' => 'bank_transfer',
                ]);
            }
            
            // Sort by date (most recent first)
            $transactionHistory = $transactionHistory->sortByDesc(function($item) {
                return $item['date'];
            })->values();
        }

        return view('sms.parent.fees', compact('children', 'studentFees', 'feesByChild', 'totalFees', 'totalPaid', 'totalBalance', 'paymentSettings', 'transactionHistory'));
    }

    /**
     * Process fee payment
     */
    public function pay(Request $request)
    {
        $smsUser = session('sms_user');
        $schoolId = $smsUser->school_id ?? null;

        $request->validate([
            'student_fee_id' => 'required|exists:sms_student_fees,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer,card,online',
            'transaction_id' => 'nullable|string',
        ]);

        $studentFee = StudentFee::findOrFail($request->student_fee_id);

        // Verify parent owns this student (check both old parent_id and new many-to-many)
        $parent = \App\Models\Sms\SmsParent::where('user_id', $smsUser->id)->first();
        if (!$parent) {
            return back()->with('error', 'Parent profile not found.');
        }
        
        $student = $studentFee->student;
        $isLinked = $student->parent_id === $parent->id 
                 || $student->linkedParents->contains($parent->id);
        
        if (!$isLinked) {
            return back()->with('error', 'Unauthorized payment attempt. You can only pay for your assigned children.');
        }

        if ($request->amount > $studentFee->balance) {
            return back()->with('error', 'Payment amount exceeds balance.');
        }

        DB::beginTransaction();

        try {
            // Create payment record
            SmsFeePayment::create([
                'school_id' => $schoolId,
                'fee_id' => $studentFee->fee_id,
                'student_id' => $studentFee->student_id,
                'student_fee_id' => $studentFee->id,
                'amount_paid' => $request->amount,
                'payment_date' => now(),
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
            ]);

            // Update student fee
            $studentFee->paid_amount += $request->amount;
            $studentFee->balance = $studentFee->amount - $studentFee->paid_amount;
            $studentFee->updateStatus();
            $studentFee->save();

            DB::commit();

            return redirect()->route('sms.parent.fees')
                ->with('success', 'Payment processed successfully. Receipt will be generated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    /**
     * Process manual bank transfer (upload proof)
     */
    public function submitManualTransfer(Request $request)
    {
        $smsUser = session('sms_user');
        $smsRole = session('sms_role');

        if ($smsRole !== 'parent') {
            return redirect()->route('sms.parent.dashboard')
                ->with('error', 'Access denied.');
        }

        // Handle both real StudentFee IDs and virtual fees
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
                    'bank_name' => 'nullable|string|max:255',
                    'account_name' => 'nullable|string|max:255',
                    'account_number' => 'nullable|string|max:255',
                    'transaction_reference' => 'nullable|string|max:255',
                    'proof_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                    'notes' => 'nullable|string|max:1000',
                ]);
                
                $student = SmsStudent::findOrFail($studentId);
                $fee = SmsFee::findOrFail($feeId);
                $school = $student->school;
                
                // Verify fee belongs to student's class
                if ($fee->class_id !== $student->class_id || $fee->school_id !== $student->school_id) {
                    return back()->with('error', 'Fee does not belong to this student\'s class.');
                }
                
                // Create or get StudentFee record
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
                
                // Recalculate balance - only count COMPLETED payments (not pending manual transfers)
                $existingPayments = SmsFeePayment::where('student_id', $studentId)
                    ->where('fee_id', $feeId)
                    ->where('payment_status', 'completed')
                    ->sum('amount_paid');
                
                // Refresh to get latest data
                $studentFee->refresh();
                
                $studentFee->paid_amount = $existingPayments;
                // Balance = fee amount - completed payments (pending transfers don't reduce balance until approved)
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
                'bank_name' => 'nullable|string|max:255',
                'account_name' => 'nullable|string|max:255',
                'account_number' => 'nullable|string|max:255',
                'transaction_reference' => 'nullable|string|max:255',
                'proof_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'notes' => 'nullable|string|max:1000',
            ]);
            
            $studentFee = StudentFee::with(['student', 'fee'])->findOrFail($validated['student_fee_id']);
            $student = $studentFee->student;
            $fee = $studentFee->fee;
            $school = $studentFee->school;
            
            // Refresh to get latest balance
            $studentFee->refresh();
            
            // Recalculate balance from completed payments only
            $existingPayments = SmsFeePayment::where('student_id', $studentFee->student_id)
                ->where('fee_id', $studentFee->fee_id)
                ->where('payment_status', 'completed')
                ->sum('amount_paid');
            
            $studentFee->paid_amount = $existingPayments;
            $studentFee->balance = max(0, $studentFee->amount - $existingPayments);
            $studentFee->save();
        }

        // Verify parent has access to this student
        $parent = \App\Models\Sms\SmsParent::where('user_id', $smsUser->id)->first();
        if (!$parent) {
            return back()->with('error', 'Parent profile not found.');
        }

        // Check if parent is linked to student (both methods)
        $isLinkedViaParentId = ($student->parent_id === $parent->id);
        $isLinkedViaPivot = \DB::table('parent_student')
            ->where('parent_id', $parent->id)
            ->where('student_id', $student->id)
            ->exists();
        $isLinked = $isLinkedViaParentId || $isLinkedViaPivot;
        
        if (!$isLinked) {
            return back()->with('error', 'You do not have access to pay fees for this student.');
        }

        $paymentAmount = $validated['amount'];
        
        // CRITICAL: Recalculate balance from database to ensure accuracy
        $completedPayments = SmsFeePayment::where('student_id', $studentFee->student_id)
            ->where('fee_id', $studentFee->fee_id)
            ->where('payment_status', 'completed')
            ->sum('amount_paid');
        
        $actualBalance = max(0, $studentFee->amount - $completedPayments);
        
        // Get pending manual transfers for this fee that haven't been approved yet
        $pendingTransfers = \App\Models\ManualTransfer::where('student_id', $studentFee->student_id)
            ->where('student_fee_id', $studentFee->id)
            ->where('status', 'pending')
            ->sum('amount');
        
        // Available balance = actual balance - pending transfers
        // This ensures parents can't submit more than what's actually available
        $availableBalance = max(0, $actualBalance - $pendingTransfers);
        
        if ($paymentAmount > $availableBalance) {
            $pendingMsg = $pendingTransfers > 0 ? ' You have ₦' . number_format($pendingTransfers, 2) . ' in pending transfers awaiting approval.' : '';
            return back()->with('error', 'Payment amount exceeds available balance. Available: ₦' . number_format($availableBalance, 2) . '.' . $pendingMsg);
        }
        
        // Also check that amount doesn't exceed the fee amount itself
        if ($paymentAmount > $studentFee->amount) {
            return back()->with('error', 'Payment amount cannot exceed the total fee amount of ₦' . number_format($studentFee->amount, 2) . '.');
        }

        try {
            // Upload proof document
            $proofPath = $request->file('proof_document')->store('payment-proofs', 'public');

            // Create manual transfer record
            $transfer = \App\Models\ManualTransfer::create([
                'school_id' => $school->id,
                'parent_id' => $parent->id,
                'student_id' => $studentFee->student_id,
                'student_fee_id' => $studentFee->id,
                'amount' => $paymentAmount,
                'bank_name' => $validated['bank_name'] ?? null,
                'account_name' => $validated['account_name'] ?? null,
                'account_number' => $validated['account_number'] ?? null,
                'transaction_reference' => $validated['transaction_reference'] ?? null,
                'proof_document' => $proofPath,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);

            \App\Models\PaymentLog::logEvent([
                'school_id' => $school->id,
                'manual_transfer_id' => $transfer->id,
                'event_type' => 'manual_transfer_submitted',
                'gateway' => 'manual',
                'transaction_reference' => $validated['transaction_reference'] ?? null,
                'amount' => $paymentAmount,
                'status' => 'pending',
            ]);

            return redirect()->route('sms.parent.fees')
                ->with('success', 'Transfer proof submitted. Awaiting admin approval.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to submit transfer: ' . $e->getMessage());
        }
    }

    /**
     * Download payment receipt
     */
    public function receipt($paymentId)
    {
        $payment = SmsFeePayment::with(['student', 'fee', 'studentFee'])->findOrFail($paymentId);

        // Verify parent owns this payment
        $smsUser = session('sms_user');
        $parent = \App\Models\Sms\SmsParent::where('user_id', $smsUser->id)->first();
        
        if (!$parent || $payment->student->parent_id !== $parent->id) {
            return back()->with('error', 'Unauthorized access.');
        }

        return view('sms.parent.receipt', compact('payment'));
    }
}
