<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\SmsFeePayment;
use App\Models\ManualTransfer;
use App\Models\Sms\StudentFee;
use Illuminate\Http\Request;

class PaymentDashboardController extends BaseSchoolController
{
    public function index(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $schoolId = $school->id;

        // Get filters
        $statusFilter = $request->get('status', 'all');
        $methodFilter = $request->get('method', 'all');
        $classFilter = $request->get('class_id', 'all');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Build payment query
        $paymentsQuery = SmsFeePayment::where('school_id', $schoolId)
            ->with(['student.user', 'student.class', 'fee', 'studentFee']);

        if ($statusFilter !== 'all') {
            $paymentsQuery->where('payment_status', $statusFilter);
        }

        if ($methodFilter !== 'all') {
            if ($methodFilter === 'online') {
                $paymentsQuery->whereIn('gateway', ['paystack', 'flutterwave', 'moniepoint']);
            } else {
                $paymentsQuery->where('payment_method', $methodFilter);
            }
        }

        if ($dateFrom) {
            $paymentsQuery->whereDate('payment_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $paymentsQuery->whereDate('payment_date', '<=', $dateTo);
        }

        if ($classFilter !== 'all') {
            $paymentsQuery->whereHas('student', function($q) use ($classFilter) {
                $q->where('class_id', $classFilter);
            });
        }

        $payments = $paymentsQuery->orderBy('created_at', 'desc')->paginate(20);

        // Statistics
        $totalExpected = StudentFee::where('school_id', $schoolId)->sum('amount');
        $totalPaid = SmsFeePayment::where('school_id', $schoolId)
            ->where('payment_status', 'success')
            ->sum('amount_paid');
        $totalOutstanding = $totalExpected - $totalPaid;

        $onlinePayments = SmsFeePayment::where('school_id', $schoolId)
            ->where('payment_status', 'success')
            ->whereIn('gateway', ['paystack', 'flutterwave', 'moniepoint'])
            ->sum('amount_paid');

        $manualPayments = SmsFeePayment::where('school_id', $schoolId)
            ->where('payment_status', 'success')
            ->where('gateway', 'manual')
            ->sum('amount_paid');

        $pendingTransfers = ManualTransfer::where('school_id', $schoolId)
            ->where('status', 'pending')
            ->count();

        // Get classes for filter
        $classes = \App\Models\Sms\SmsClass::where('school_id', $schoolId)->get();

        // Get parent payments view (flattened list with parent info)
        $parentPaymentsList = SmsFeePayment::where('school_id', $schoolId)
            ->where('payment_status', 'success')
            ->with(['student.user', 'student.class', 'student.linkedParents.user', 'student.parent.user', 'fee', 'studentFee'])
            ->orderBy('payment_date', 'desc')
            ->get()
            ->map(function($payment) {
                $parent = $payment->student->linkedParents->first() ?? 
                         ($payment->student->parent ? $payment->student->parent : null);
                return [
                    'payment' => $payment,
                    'parent_name' => $parent ? $parent->user->name : 'Unknown',
                ];
            });

        return view('school.payments.dashboard', compact(
            'payments', 
            'totalPaid', 
            'totalOutstanding',
            'onlinePayments',
            'manualPayments',
            'pendingTransfers',
            'classes',
            'statusFilter',
            'methodFilter',
            'classFilter',
            'dateFrom',
            'dateTo',
            'parentPaymentsList'
        ));
    }

    public function export(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return back()->with('error', 'School not found.');
        }

        // Similar query building as index, but export to CSV
        // Implementation for CSV export
        // This is a placeholder - implement CSV export using Laravel Excel or similar
        return back()->with('info', 'Export feature coming soon.');
    }
}
