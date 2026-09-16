<?php

namespace App\Http\Controllers\School;

use Illuminate\Http\Request;

class ExamManagementController extends BaseSchoolController
{
    public function index()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $exams = \App\Models\Sms\SmsExam::where('school_id', $school->id)
            ->with(['subject', 'class'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('school.exams.index', compact('exams', 'school'));
    }

    public function create()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $subjects = \App\Models\Sms\SmsSubject::where('school_id', $school->id)
            ->where('is_active', true)
            ->get();
            
        $classes = \App\Models\Sms\SmsClass::where('school_id', $school->id)
            ->orderBy('name')
            ->get();

        return view('school.exams.create', compact('subjects', 'classes', 'school'));
    }

    public function store(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:sms_subjects,id',
            'class_id' => 'required|exists:sms_classes,id',
            'exam_type' => 'required|in:CA1,CA2,Test,Exam',
            'duration_minutes' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'scheduled_date' => 'nullable|date',
            'scheduled_time' => 'nullable|date_format:H:i',
        ]);

        $smsUser = session('sms_user');
        
        $exam = \App\Models\Sms\SmsExam::create([
            'school_id' => $school->id,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'title' => $request->title,
            'description' => $request->description,
            'exam_type' => $request->exam_type,
            'duration_minutes' => $request->duration_minutes,
            'passing_score' => $request->passing_score,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'created_by' => $smsUser ? $smsUser->id : null,
            'is_active' => true,
        ]);

        return redirect()->route('school.exams.questions.create', $exam->id)
            ->with('success', 'Exam created successfully. Now add questions.');
    }

    public function show($examId)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $exam = \App\Models\Sms\SmsExam::where('school_id', $school->id)
            ->where('id', $examId)
            ->with(['subject', 'class', 'questions'])
            ->firstOrFail();

        return view('school.exams.show', compact('exam', 'school'));
    }

    public function createQuestions($examId)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $exam = \App\Models\Sms\SmsExam::where('school_id', $school->id)
            ->where('id', $examId)
            ->firstOrFail();

        return view('school.exams.questions.create', compact('exam', 'school'));
    }

    public function storeQuestions(Request $request, $examId)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $exam = \App\Models\Sms\SmsExam::where('school_id', $school->id)
            ->where('id', $examId)
            ->firstOrFail();

        $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:multiple_choice,true_false',
            'questions.*.options' => 'required_if:questions.*.question_type,multiple_choice|array',
            'questions.*.correct_answer' => 'required|string',
            'questions.*.points' => 'required|integer|min:1',
        ]);

        foreach ($request->questions as $index => $questionData) {
            \App\Models\Sms\SmsExamQuestion::create([
                'exam_id' => $exam->id,
                'question_text' => $questionData['question_text'],
                'question_type' => $questionData['question_type'],
                'options' => isset($questionData['options']) ? json_encode($questionData['options']) : null,
                'correct_answer' => $questionData['correct_answer'],
                'points' => $questionData['points'] ?? 1,
                'order' => $index + 1,
            ]);
        }

        $exam->update(['total_questions' => $exam->questions()->count()]);

        return redirect()->route('school.exams.show', $exam->id)
            ->with('success', 'Questions added successfully.');
    }
}
