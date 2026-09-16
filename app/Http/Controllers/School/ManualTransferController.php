<?php

namespace App\Http\Controllers\School;

use App\Models\ManualTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManualTransferController extends BaseSchoolController
{
    public function index(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $query = ManualTransfer::where('school_id', $school->id)
            ->with(['parent.user', 'student.user', 'studentFee.fee']);

        // Filter by status
        $statusFilter = $request->get('status', 'all');
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $transfers = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('school.payments.manual-transfers', compact('transfers', 'school', 'statusFilter'));

    }

    public function approve($id)
    {
        $school = $this->getSchool();
        $smsUser = session('sms_user');

        if (!$school || !$smsUser) {
            return back()->with('error', 'Unauthorized.');
        }

        $transfer = ManualTransfer::where('school_id', $school->id)
            ->where('id', $id)
            ->firstOrFail();

        if ($transfer->status !== 'pending') {
            return back()->with('error', 'Transfer already processed.');
        }

        try {
            $transfer->approve($smsUser);
            return back()->with('success', 'Transfer approved and payment recorded.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve transfer: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $school = $this->getSchool();
        $smsUser = session('sms_user');

        if (!$school || !$smsUser) {
            return back()->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $transfer = ManualTransfer::where('school_id', $school->id)
            ->where('id', $id)
            ->firstOrFail();

        if ($transfer->status !== 'pending') {
            return back()->with('error', 'Transfer already processed.');
        }

        $transfer->reject($smsUser, $validated['rejection_reason']);
        
        return back()->with('success', 'Transfer rejected.');
    }

    public function showProof($id)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            abort(404);
        }

        $transfer = ManualTransfer::where('school_id', $school->id)
            ->where('id', $id)
            ->firstOrFail();

        if (!$transfer->proof_document) {
            abort(404);
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($transfer->proof_document)) {
            abort(404, 'Proof document not found.');
        }

        // Return the file response with proper headers
        return Storage::disk('public')->response($transfer->proof_document);
    }
}
