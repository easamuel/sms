<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\SmsNotice;
use Illuminate\Http\Request;

class NoticeController extends BaseSchoolController
{
    public function index()
    {
        $school = $this->getSchool();
        if (!$school) {
            return redirect()->route('school-management.demo-login')->with('error', 'School not found. Please login again.');
        }

        $notices = SmsNotice::where('school_id', $school->id)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('school.notices.index', compact('notices'));
    }

    public function create()
    {
        $school = $this->getSchool();
        if (!$school) {
            return redirect()->route('school-management.demo-login')->with('error', 'School not found. Please login again.');
        }

        return view('school.notices.create');
    }

    public function store(Request $request)
    {
        $school = $this->getSchool();
        if (!$school) {
            return redirect()->route('school-management.demo-login')->with('error', 'School not found. Please login again.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'target_audience' => 'required|in:all,students,teachers,parents',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
            'is_active' => 'boolean',
        ]);

        $validated['school_id'] = $school->id;
        $validated['published_at'] = $validated['published_at'] ?? now();
        $validated['is_active'] = $request->has('is_active') ? true : false;

        SmsNotice::create($validated);

        return redirect()->route('school.notices.index')
            ->with('success', 'Notice created successfully.');
    }

    public function edit(SmsNotice $notice)
    {
        $school = $this->getSchool();
        if (!$school || $notice->school_id !== $school->id) {
            return redirect()->route('school.notices.index')
                ->with('error', 'Unauthorized access.');
        }

        return view('school.notices.edit', compact('notice'));
    }

    public function update(Request $request, SmsNotice $notice)
    {
        $school = $this->getSchool();
        if (!$school || $notice->school_id !== $school->id) {
            return redirect()->route('school.notices.index')
                ->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'target_audience' => 'required|in:all,students,teachers,parents',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $notice->update($validated);

        return redirect()->route('school.notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    public function destroy(SmsNotice $notice)
    {
        $school = $this->getSchool();
        if (!$school || $notice->school_id !== $school->id) {
            return redirect()->route('school.notices.index')
                ->with('error', 'Unauthorized access.');
        }

        $notice->delete();

        return redirect()->route('school.notices.index')
            ->with('success', 'Notice deleted successfully.');
    }
}
