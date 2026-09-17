<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sms\SmsClass;
use App\Models\Sms\SmsSchool;
use Illuminate\Support\Facades\Log;

class AdmissionController extends Controller
{
    /**
     * Display the online admission application form.
     */
    public function index()
    {
        // Try fetching active classes from the database, or provide standard Nigerian class levels
        try {
            $classes = SmsClass::where('is_active', true)->orderBy('name')->get();
            if ($classes->isEmpty()) {
                $classes = collect([
                    (object)['id' => 1, 'name' => 'Creche / Playgroup'],
                    (object)['id' => 2, 'name' => 'Nursery 1'],
                    (object)['id' => 3, 'name' => 'Nursery 2'],
                    (object)['id' => 4, 'name' => 'Basic 1 (Primary 1)'],
                    (object)['id' => 5, 'name' => 'Basic 2 (Primary 2)'],
                    (object)['id' => 6, 'name' => 'Basic 3 (Primary 3)'],
                    (object)['id' => 7, 'name' => 'Basic 4 (Primary 4)'],
                    (object)['id' => 8, 'name' => 'Basic 5 (Primary 5)'],
                    (object)['id' => 9, 'name' => 'Basic 6 (Primary 6)'],
                    (object)['id' => 10, 'name' => 'JSS 1 (Basic 7)'],
                    (object)['id' => 11, 'name' => 'JSS 2 (Basic 8)'],
                    (object)['id' => 12, 'name' => 'JSS 3 (Basic 9)'],
                    (object)['id' => 13, 'name' => 'SSS 1 (Science / Art / Comm)'],
                    (object)['id' => 14, 'name' => 'SSS 2 (Science / Art / Comm)'],
                    (object)['id' => 15, 'name' => 'SSS 3 (WAEC / NECO Prep)'],
                ]);
            }
        } catch (\Throwable $e) {
            $classes = collect([
                (object)['id' => 1, 'name' => 'Nursery 1'],
                (object)['id' => 2, 'name' => 'Nursery 2'],
                (object)['id' => 3, 'name' => 'Basic 1'],
                (object)['id' => 4, 'name' => 'Basic 2'],
                (object)['id' => 5, 'name' => 'Basic 3'],
                (object)['id' => 6, 'name' => 'Basic 4'],
                (object)['id' => 7, 'name' => 'Basic 5'],
                (object)['id' => 8, 'name' => 'JSS 1'],
                (object)['id' => 9, 'name' => 'JSS 2'],
                (object)['id' => 10, 'name' => 'JSS 3'],
                (object)['id' => 11, 'name' => 'SSS 1'],
                (object)['id' => 12, 'name' => 'SSS 2'],
                (object)['id' => 13, 'name' => 'SSS 3'],
            ]);
        }

        $sessionYear = '2026/2027';

        return view('admission', compact('classes', 'sessionYear'));
    }

    /**
     * Process an online admission application.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'gender' => 'required|string|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'class_applied' => 'required|string|max:100',
            'academic_session' => 'nullable|string|max:50',
            'parent_name' => 'required|string|max:150',
            'parent_relationship' => 'required|string|max:50',
            'parent_phone' => 'required|string|max:25',
            'parent_email' => 'required|email|max:150',
            'parent_occupation' => 'nullable|string|max:100',
            'residential_address' => 'required|string|max:255',
            'state_of_origin' => 'nullable|string|max:100',
            'previous_school' => 'nullable|string|max:200',
            'last_class_passed' => 'nullable|string|max:100',
            'medical_conditions' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:50',
        ]);

        // Generate a distinctive Application Reference Number
        $applicationId = 'ADM-' . date('Y') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));

        $applicationData = array_merge($validated, [
            'application_number' => $applicationId,
            'submitted_at' => now()->format('F j, Y, g:i a'),
            'status' => 'Pending Review',
        ]);

        // Store into session for receipt rendering
        session()->flash('admission_success', true);
        session()->flash('admission_data', $applicationData);

        return redirect()->route('admission.create')
            ->with('success', 'Application submitted successfully! Your Application ID is: ' . $applicationId);
    }
}

