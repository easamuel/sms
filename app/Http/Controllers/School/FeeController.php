<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\SmsFee;
use App\Models\Sms\SmsFeePayment;
use App\Models\Sms\SmsClass;
use Illuminate\Http\Request;

class FeeController extends BaseSchoolController
{
    public function index()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $schoolId = $school->id;
        
        $fees = SmsFee::where('school_id', $schoolId)
            ->with('class')
            ->orderBy('name')
            ->orderBy('class_id')
            ->get();

        // Group fees by name
        $groupedFees = $fees->groupBy('name');

        $payments = SmsFeePayment::where('school_id', $schoolId)
            ->with(['fee', 'student.user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $classes = SmsClass::where('school_id', $schoolId)->get();

        return view('school.fees.index', compact('fees', 'groupedFees', 'payments', 'classes'));
    }

    public function store(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $schoolId = $school->id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:sms_classes,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'academic_year' => 'required|string',
        ]);

        SmsFee::create([
            'school_id' => $schoolId,
            'class_id' => $validated['class_id'],
            'name' => $validated['name'],
            'amount' => $validated['amount'],
            'due_date' => $validated['due_date'],
            'academic_year' => $validated['academic_year'],
            'is_active' => true,
        ]);

        return redirect()->route('school.fees.index')
            ->with('success', 'Fee structure created successfully.');
    }

    public function recordPayment(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $schoolId = $school->id;

        $validated = $request->validate([
            'fee_id' => 'required|exists:sms_fees,id',
            'student_id' => 'required|exists:sms_students,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
        ]);

        SmsFeePayment::create([
            'school_id' => $schoolId,
            'fee_id' => $validated['fee_id'],
            'student_id' => $validated['student_id'],
            'amount_paid' => $validated['amount_paid'],
            'payment_date' => $validated['payment_date'],
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'] ?? null,
        ]);

        return redirect()->back()
            ->with('success', 'Payment recorded successfully.');
    }

    public function edit($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $fee = SmsFee::where('school_id', $school->id)
            ->where('id', $id)
            ->with('class')
            ->firstOrFail();

        $classes = SmsClass::where('school_id', $school->id)->get();

        return view('school.fees.edit', compact('fee', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $fee = SmsFee::where('school_id', $school->id)
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:sms_classes,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'academic_year' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $fee->update([
            'class_id' => $validated['class_id'],
            'name' => $validated['name'],
            'amount' => $validated['amount'],
            'due_date' => $validated['due_date'],
            'academic_year' => $validated['academic_year'],
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('school.fees.index')
            ->with('success', 'Fee structure updated successfully.');
    }

    public function bulkCreate(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $request->validate([
            'fee_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'academic_year' => 'required|string',
            'class_ids' => 'required|array|min:1',
            'class_ids.*' => 'exists:sms_classes,id',
        ]);

        $created = 0;
        $skipped = 0;

        foreach ($request->class_ids as $classId) {
            // Check if fee already exists for this class
            $exists = SmsFee::where('school_id', $school->id)
                ->where('class_id', $classId)
                ->where('name', $request->fee_name)
                ->where('academic_year', $request->academic_year)
                ->exists();

            if (!$exists) {
                SmsFee::create([
                    'school_id' => $school->id,
                    'class_id' => $classId,
                    'name' => $request->fee_name,
                    'amount' => $request->amount,
                    'due_date' => $request->due_date,
                    'academic_year' => $request->academic_year,
                    'is_active' => true,
                ]);
                $created++;
            } else {
                $skipped++;
            }
        }

        $message = "Bulk fee creation completed. {$created} fee structures created";
        if ($skipped > 0) {
            $message .= ", {$skipped} already existed and were skipped";
        }
        $message .= ".";

        return redirect()->route('school.fees.index')
            ->with('success', $message);
    }

    public function destroy($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $fee = SmsFee::where('school_id', $school->id)
            ->where('id', $id)
            ->firstOrFail();

        // Check if there are any payments
        if ($fee->payments()->count() > 0) {
            return redirect()->route('school.fees.index')
                ->with('error', 'Cannot delete fee structure with existing payments. Deactivate it instead.');
        }

        $fee->delete();

        return redirect()->route('school.fees.index')
            ->with('success', 'Fee structure deleted successfully.');
    }

    public function studentFees()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $schoolId = $school->id;

        // Get all active students with their fee information (exclude deleted/inactive students)
        $students = \App\Models\Sms\SmsStudent::where('school_id', $schoolId)
            ->where('status', 'active')
            ->whereHas('user', function($query) {
                $query->where('is_active', true);
            })
            ->with(['user', 'class', 'feePayments.fee'])
            ->orderBy('student_id_number')
            ->get();

        // Get all active fees for the school
        $allFees = SmsFee::where('school_id', $schoolId)
            ->where('is_active', true)
            ->with('class')
            ->get();

        // Calculate fee status for each student
        $studentsWithFees = $students->map(function($student) use ($allFees, $schoolId) {
            // Get fees applicable to this student's class
            $applicableFees = $allFees->where('class_id', $student->class_id);
            
            $totalFees = $applicableFees->sum('amount');
            $totalPaid = $this->calculateTotalPaid($student->id, $applicableFees);
            $totalBalance = $totalFees - $totalPaid;
            $percentagePaid = $totalFees > 0 ? ($totalPaid / $totalFees) * 100 : 0;
            
            // Check if student can write exams (at least 50% paid)
            $canWriteExams = $percentagePaid >= 50;
            
            return [
                'student' => $student,
                'totalFees' => $totalFees,
                'totalPaid' => $totalPaid,
                'totalBalance' => $totalBalance,
                'percentagePaid' => round($percentagePaid, 2),
                'canWriteExams' => $canWriteExams,
                'applicableFees' => $applicableFees,
            ];
        });

        $classes = \App\Models\Sms\SmsClass::where('school_id', $schoolId)->get();

        return view('school.fees.student-fees', compact('studentsWithFees', 'allFees', 'classes', 'school'));
    }

    public function recordStudentPayment(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:sms_students,id',
            'fee_id' => 'required|exists:sms_fees,id',
            'amount_paid' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,card,cheque',
            'transaction_id' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Verify student belongs to school
        $student = \App\Models\Sms\SmsStudent::where('school_id', $school->id)
            ->where('id', $validated['student_id'])
            ->firstOrFail();

        // Verify fee belongs to school and student's class
        $fee = SmsFee::where('school_id', $school->id)
            ->where('id', $validated['fee_id'])
            ->where('class_id', $student->class_id)
            ->firstOrFail();

        // Create payment record
        SmsFeePayment::create([
            'school_id' => $school->id,
            'fee_id' => $validated['fee_id'],
            'student_id' => $validated['student_id'],
            'amount_paid' => $validated['amount_paid'],
            'payment_date' => $validated['payment_date'],
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return redirect()->route('school.fees.student-fees')
            ->with('success', "Payment of ₦" . number_format($validated['amount_paid'], 2) . " recorded successfully for " . $student->user->name . ".");
    }

    private function calculateTotalPaid($studentId, $fees)
    {
        // Calculate total paid for all fees (matching the exam system logic)
        // This sums all payments for the student, not just specific fees
        return \App\Models\Sms\SmsFeePayment::where('student_id', $studentId)
            ->sum('amount_paid');
    }

}
