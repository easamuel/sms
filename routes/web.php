<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SchoolManagementController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\PaymentWebhookController;
use App\Http\Controllers\School\DashboardController as SchoolDashboardController;
use App\Http\Controllers\School\StudentController;
use App\Http\Controllers\School\StaffController;
use App\Http\Controllers\School\ClassSectionController;
use App\Http\Controllers\School\SubjectController;
use App\Http\Controllers\School\AttendanceController;
use App\Http\Controllers\School\TimetableController;
use App\Http\Controllers\School\ExamManagementController;
use App\Http\Controllers\School\ResultController;
use App\Http\Controllers\School\FeeController;
use App\Http\Controllers\School\PaymentSettingsController;
use App\Http\Controllers\School\PaymentDashboardController;
use App\Http\Controllers\School\ManualTransferController;
use App\Http\Controllers\School\ParentController;
use App\Http\Controllers\School\RegisterParentController;
use App\Http\Controllers\School\ParentStudentController;
use App\Http\Controllers\School\MessageController;
use App\Http\Controllers\School\NoticeController;
use App\Http\Controllers\Sms\SmsStudentController;
use App\Http\Controllers\Sms\SmsStudentExamController;
use App\Http\Controllers\Sms\SmsTimetableController;
use App\Http\Controllers\Sms\SmsParentController;
use App\Http\Controllers\Sms\SmsFeePaymentController;
use App\Http\Controllers\Sms\ParentMessageController;
use App\Http\Controllers\Sms\SmsTeacherController;
use App\Http\Controllers\Sms\SmsTeacherExamController;
use App\Http\Controllers\Sms\ResultsEntryController;
use App\Http\Controllers\Sms\SmsAdminController;
use App\Http\Controllers\Sms\SmsLogoutController;

/*
|--------------------------------------------------------------------------
| Web Routes - ExtremeSolutions School Management System (ES-Schools)
|--------------------------------------------------------------------------
|
| All web routes for public landing pages, authentication, school admin,
| teacher portal, student portal, parent portal, and payment gateways.
|
*/

// ==========================================
// 1. PUBLIC & MARKETING ROUTES
// ==========================================
Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

Route::get('/privacy-policy', function() { return view('policies.privacy-policy'); })->name('privacy-policy');
Route::get('/terms-of-service', function() { return view('policies.terms-of-service'); })->name('terms-of-service');
Route::get('/cookie-policy', function() { return view('policies.cookie-policy'); })->name('cookie-policy');

// ==========================================
// 2. AUTHENTICATION & DEMO LOGIN SWITCHER
// ==========================================
Route::get('/login', [SchoolManagementController::class, 'showAuthorizedLogin'])->name('login');
Route::post('/login', [SchoolManagementController::class, 'authorizedLogin'])->name('login.submit');
Route::post('/logout', [SmsLogoutController::class, 'logout'])->name('logout');

Route::prefix('school-management')->name('school-management.')->group(function () {
    Route::get('/', [SchoolManagementController::class, 'index'])->name('index');
    Route::get('/demo-login', [SchoolManagementController::class, 'showDemoLogin'])->name('demo-login');
    Route::post('/demo-login', [SchoolManagementController::class, 'demoLogin'])->name('demo-login.submit');
    Route::get('/authorized-login', [SchoolManagementController::class, 'showAuthorizedLogin'])->name('authorized-login');
    Route::post('/authorized-login', [SchoolManagementController::class, 'authorizedLogin'])->name('authorized-login.submit');
});

Route::post('/sms/logout', [SmsLogoutController::class, 'logout'])->name('sms.logout');

// ==========================================
// 3. STUDENT PORTAL (/sms/student/*)
// ==========================================
Route::prefix('sms/student')->name('sms.student.')->middleware('sms.auth')->group(function () {
    Route::get('/dashboard', [SmsStudentController::class, 'dashboard'])->name('dashboard');
    Route::post('/change-password', [SmsStudentController::class, 'changePassword'])->name('change-password');
    Route::get('/attendance', [SmsStudentController::class, 'attendance'])->name('attendance');
    Route::get('/timetable', [SmsTimetableController::class, 'index'])->name('timetable');
    Route::get('/exams', [SmsStudentController::class, 'exams'])->name('exams');
    Route::get('/exams/{exam}/take', [SmsStudentExamController::class, 'take'])->name('exams.take');
    Route::post('/exams/{exam}/start', [SmsStudentExamController::class, 'start'])->name('exams.start');
    Route::get('/exams/subject/{subject}/practice', [SmsStudentExamController::class, 'practice'])->name('exams.practice');
    Route::post('/exams/session/{session}/answer', [SmsStudentExamController::class, 'saveAnswer'])->name('exams.save-answer');
    Route::post('/exams/session/{session}/submit', [SmsStudentExamController::class, 'submit'])->name('exams.submit');
    Route::get('/exams/session/{session}/result', [SmsStudentExamController::class, 'result'])->name('exams.result');
    Route::get('/assignments', [SmsStudentController::class, 'assignments'])->name('assignments');
    Route::get('/practice-sessions', [SmsStudentController::class, 'practiceSessions'])->name('practice-sessions');
    Route::match(['get', 'post'], '/practice-sessions/{id}/take', [SmsStudentController::class, 'takePracticeSession'])->name('practice-sessions.take');
    Route::post('/practice-sessions/{id}/submit', [SmsStudentController::class, 'submitPracticeSession'])->name('practice-sessions.submit');
    Route::get('/practice-sessions/attempt/{id}/result', [SmsStudentController::class, 'practiceSessionResult'])->name('practice-sessions.result');
    Route::get('/results', [SmsStudentController::class, 'results'])->name('results');
    Route::get('/results/download-pdf', [SmsStudentController::class, 'downloadResultPdf'])->name('results.download-pdf');
    Route::get('/fees', [SmsStudentController::class, 'fees'])->name('fees');
    Route::get('/notices', [SmsStudentController::class, 'notices'])->name('notices');
});

// ==========================================
// 4. PARENT PORTAL (/sms/parent/*)
// ==========================================
Route::prefix('sms/parent')->name('sms.parent.')->middleware('sms.auth')->group(function () {
    Route::get('/dashboard', [SmsParentController::class, 'dashboard'])->name('dashboard');
    Route::get('/children', [SmsParentController::class, 'children'])->name('children');
    Route::get('/children/{student}/attendance', [SmsParentController::class, 'childAttendance'])->name('children.attendance');
    Route::get('/children/{student}/results', [SmsParentController::class, 'childResults'])->name('children.results');
    
    // Parent fee payment
    Route::get('/fees', [SmsFeePaymentController::class, 'index'])->name('fees');
    Route::post('/fees/pay', [SmsParentController::class, 'payFee'])->name('fees.pay');
    Route::post('/fees/initiate', [PaymentController::class, 'initiate'])->name('fees.initiate');
    Route::post('/fees/manual-transfer', [SmsFeePaymentController::class, 'submitManualTransfer'])->name('fees.manual-transfer');
    Route::get('/fees/receipt/{paymentId}', [SmsFeePaymentController::class, 'receipt'])->name('fees.receipt');
    
    // Parent Messages & Notices
    Route::get('/messages', [ParentMessageController::class, 'index'])->name('messages');
    Route::post('/messages/send', [ParentMessageController::class, 'send'])->name('messages.send');
    Route::get('/notices', [SmsParentController::class, 'notices'])->name('notices');
    
    // Parent student context switching
    Route::get('/view-child/{childId}', [SmsParentController::class, 'viewChild'])->name('view-child');
    Route::get('/restore-session', [SmsParentController::class, 'restoreParentSession'])->name('restore-session');
});

// ==========================================
// 5. TEACHER PORTAL (/sms/teacher/*)
// ==========================================
Route::prefix('sms/teacher')->name('sms.teacher.')->middleware('sms.auth')->group(function () {
    Route::get('/dashboard', [SmsTeacherController::class, 'dashboard'])->name('dashboard');
    
    // Exams & CBT
    Route::get('/exams', [SmsTeacherController::class, 'exams'])->name('exams');
    Route::get('/exams/create', [SmsTeacherController::class, 'createExam'])->name('exams.create');
    Route::post('/exams', [SmsTeacherController::class, 'storeExam'])->name('exams.store');
    Route::get('/exams/{exam}/questions/create', [SmsTeacherExamController::class, 'createQuestions'])->name('exams.questions.create');
    Route::post('/exams/{exam}/questions', [SmsTeacherExamController::class, 'storeQuestions'])->name('exams.questions.store');
    Route::post('/exams/{exam}/questions/upload-csv', [SmsTeacherExamController::class, 'uploadCsv'])->name('exams.questions.upload-csv');
    Route::get('/exams/{exam}/questions/download-template', [SmsTeacherExamController::class, 'downloadTemplate'])->name('exams.questions.download-template');
    
    // Results & Grading
    Route::get('/results', [SmsTeacherController::class, 'results'])->name('results');
    Route::get('/results/upload', [SmsTeacherController::class, 'showUploadResultsForm'])->name('results.upload');
    Route::post('/results/upload', [SmsTeacherController::class, 'uploadResults'])->name('results.upload.store');
    Route::get('/results/download-template', [SmsTeacherController::class, 'downloadResultsTemplate'])->name('results.download-template');
    Route::post('/results/upload-csv', [SmsTeacherController::class, 'uploadResultsCsv'])->name('results.upload-csv');
    
    // Results Entry System
    Route::get('/results-entry', [ResultsEntryController::class, 'index'])->name('results-entry.index');
    Route::post('/results-entry', [ResultsEntryController::class, 'store'])->name('results-entry.store');
    Route::post('/results-entry/upload-csv', [ResultsEntryController::class, 'uploadCsv'])->name('results-entry.upload-csv');
    Route::get('/results-entry/download-template', [ResultsEntryController::class, 'downloadTemplate'])->name('results-entry.download-template');
    Route::post('/results-entry/assessments', [ResultsEntryController::class, 'storeAssessments'])->name('results-entry.store-assessments');
    Route::get('/results-entry/download-psychomotor-template', [ResultsEntryController::class, 'downloadPsychomotorTemplate'])->name('results-entry.download-psychomotor-template');
    Route::post('/results-entry/upload-psychomotor-csv', [ResultsEntryController::class, 'uploadPsychomotorCsv'])->name('results-entry.upload-psychomotor-csv');
    
    // Assignments
    Route::get('/assignments', [SmsTeacherController::class, 'assignments'])->name('assignments');
    Route::get('/assignments/create', [SmsTeacherController::class, 'createAssignment'])->name('assignments.create');
    Route::post('/assignments', [SmsTeacherController::class, 'storeAssignment'])->name('assignments.store');
    
    // Practice Sessions
    Route::get('/practice-sessions', [SmsTeacherController::class, 'practiceSessions'])->name('practice-sessions');
    Route::get('/practice-sessions/create', [SmsTeacherController::class, 'createPracticeSession'])->name('practice-sessions.create');
    Route::get('/practice-sessions/{id}', [SmsTeacherController::class, 'showPracticeSession'])->name('practice-sessions.show');
    Route::post('/practice-sessions', [SmsTeacherController::class, 'storePracticeSession'])->name('practice-sessions.store');
    Route::post('/practice-sessions/upload-csv', [SmsTeacherController::class, 'uploadPracticeSessionCsv'])->name('practice-sessions.upload-csv');
    Route::get('/practice-sessions/download-template', [SmsTeacherController::class, 'downloadPracticeTemplate'])->name('practice-sessions.download-template');
    Route::get('/practice-sessions/download-english-questions', [SmsTeacherController::class, 'downloadEnglishQuestions'])->name('practice-sessions.download-english-questions');
    
    // Question Bank, Timetable, Attendance, Notices
    Route::get('/question-bank', [SmsTeacherController::class, 'questionBank'])->name('question-bank');
    Route::get('/timetable', [SmsTeacherController::class, 'timetable'])->name('timetable');
    Route::get('/attendance', [SmsTeacherController::class, 'attendance'])->name('attendance');
    Route::post('/attendance/mark', [SmsTeacherController::class, 'markAttendance'])->name('attendance.mark');
    Route::get('/notices', [SmsTeacherController::class, 'notices'])->name('notices');
});

// ==========================================
// 6. SMS ADMIN SHORTCUT ROUTE
// ==========================================
Route::prefix('sms/admin')->name('sms.admin.')->middleware('sms.auth')->group(function () {
    Route::get('/dashboard', [SmsAdminController::class, 'dashboard'])->name('dashboard');
});

// ==========================================
// 7. SCHOOL MANAGEMENT SYSTEM (ADMIN PORTAL)
// ==========================================
Route::prefix('school')->name('school.')->group(function () {
    Route::get('/dashboard', [SchoolDashboardController::class, 'index'])->name('dashboard');
    Route::match(['get', 'post'], '/logout', [SmsLogoutController::class, 'logout'])->name('logout');
    
    // Student Management
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'addStudent'])->name('students.store');
    Route::get('/students/id-cards', [StudentController::class, 'idCards'])->name('students.id-cards');
    Route::get('/students/id-cards/download-all', [StudentController::class, 'downloadAllIdCards'])->name('students.id-cards.download-all');
    Route::get('/students/{id}/id-card/download', [StudentController::class, 'downloadIdCard'])->name('students.id-cards.download');
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::post('/students/cleanup-demo', [StudentController::class, 'cleanupDemoAccounts'])->name('students.cleanup-demo');
    
    // Staff / Teacher Management
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{id}', [StaffController::class, 'show'])->name('staff.show');
    Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');
    Route::post('/staff/{id}/assign-subjects', [StaffController::class, 'assignSubjects'])->name('staff.assign-subjects');
    Route::delete('/staff/{id}/subjects/{subjectId}', [StaffController::class, 'removeSubject'])->name('staff.remove-subject');
    Route::post('/staff/{id}/assign-classes', [StaffController::class, 'assignClasses'])->name('staff.assign-classes');
    Route::delete('/staff/{id}/classes/{classId}', [StaffController::class, 'removeClass'])->name('staff.remove-class');
    
    // Academic Setup (Classes & Subjects)
    Route::get('/classes', [ClassSectionController::class, 'index'])->name('classes.index');
    Route::post('/classes', [ClassSectionController::class, 'store'])->name('classes.store');
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::post('/subjects/bulk-create', [SubjectController::class, 'bulkCreate'])->name('subjects.bulk-create');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    
    // Attendance & Timetable
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/mark', [AttendanceController::class, 'mark'])->name('attendance.mark');
    Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable.index');
    Route::post('/timetable', [TimetableController::class, 'store'])->name('timetable.store');
    
    // Exams & CBT
    Route::get('/exams', [ExamManagementController::class, 'index'])->name('exams.index');
    Route::get('/exams/create', [ExamManagementController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamManagementController::class, 'store'])->name('exams.store');
    Route::get('/exams/{examId}', [ExamManagementController::class, 'show'])->name('exams.show');
    Route::get('/exams/{examId}/questions/create', [ExamManagementController::class, 'createQuestions'])->name('exams.questions.create');
    Route::post('/exams/{examId}/questions', [ExamManagementController::class, 'storeQuestions'])->name('exams.questions.store');
    
    // Results & Reports
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    Route::post('/results', [ResultController::class, 'store'])->name('results.store');
    Route::post('/results/upload', [ResultController::class, 'uploadExcel'])->name('results.upload');
    Route::get('/results/student/{student}/slip', [ResultController::class, 'generateResultSlip'])->name('results.slip');
    
    // Fees & Invoicing
    Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');
    Route::post('/fees', [FeeController::class, 'store'])->name('fees.store');
    Route::post('/fees/bulk-create', [FeeController::class, 'bulkCreate'])->name('fees.bulk-create');
    Route::get('/fees/{id}/edit', [FeeController::class, 'edit'])->name('fees.edit');
    Route::put('/fees/{id}', [FeeController::class, 'update'])->name('fees.update');
    Route::delete('/fees/{id}', [FeeController::class, 'destroy'])->name('fees.destroy');
    Route::post('/fees/payment', [FeeController::class, 'recordPayment'])->name('fees.payment');
    Route::get('/fees/students', [FeeController::class, 'studentFees'])->name('fees.student-fees');
    Route::post('/fees/students/payment', [FeeController::class, 'recordStudentPayment'])->name('fees.record-student-payment');
    
    // Payments Dashboard, Manual Transfers & Settings
    Route::get('/payments', [PaymentDashboardController::class, 'index'])->name('payments.index');
    Route::get('/payments/settings', [PaymentSettingsController::class, 'index'])->name('payments.settings');
    Route::post('/payments/settings', [PaymentSettingsController::class, 'update'])->name('payments.settings.update');
    Route::get('/payments/manual-transfers', [ManualTransferController::class, 'index'])->name('payments.manual-transfers');
    Route::post('/payments/manual-transfers/{id}/approve', [ManualTransferController::class, 'approve'])->name('payments.manual-transfers.approve');
    Route::post('/payments/manual-transfers/{id}/reject', [ManualTransferController::class, 'reject'])->name('payments.manual-transfers.reject');
    Route::get('/payments/manual-transfers/{id}/proof', [ManualTransferController::class, 'showProof'])->name('payments.manual-transfers.proof');
    
    // Parents Management
    Route::get('/parents', [ParentController::class, 'index'])->name('parents.index');
    Route::get('/parents/register', [RegisterParentController::class, 'index'])->name('parents.register');
    Route::post('/parents/register', [RegisterParentController::class, 'store'])->name('parents.register.store');
    Route::get('/parents/search-students', [RegisterParentController::class, 'searchStudents'])->name('parents.search-students');
    Route::get('/parents/{id}', [ParentController::class, 'show'])->name('parents.show');
    Route::get('/parents/{id}/edit', [ParentController::class, 'edit'])->name('parents.edit');
    Route::put('/parents/{id}', [ParentController::class, 'update'])->name('parents.update');
    Route::delete('/parents/{id}', [ParentController::class, 'destroy'])->name('parents.destroy');
    
    // Parent-Student Assignment
    Route::get('/students/assign-parent', [ParentStudentController::class, 'index'])->name('students.assign-parent');
    Route::post('/students/assign-parent', [ParentStudentController::class, 'assign'])->name('students.assign-parent');
    Route::post('/students/{studentId}/remove-parent/{parentId}', [ParentStudentController::class, 'remove'])->name('students.remove-parent');
    
    // Communication (Messages & Notice Board)
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{threadId}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{threadId}/send', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
    Route::get('/notices/create', [NoticeController::class, 'create'])->name('notices.create');
    Route::post('/notices', [NoticeController::class, 'store'])->name('notices.store');
    Route::get('/notices/{notice}/edit', [NoticeController::class, 'edit'])->name('notices.edit');
    Route::put('/notices/{notice}', [NoticeController::class, 'update'])->name('notices.update');
    Route::delete('/notices/{notice}', [NoticeController::class, 'destroy'])->name('notices.destroy');
});

// ==========================================
// 8. PAYMENT GATEWAYS & WEBHOOKS
// ==========================================
Route::prefix('payment/webhook')->name('payment.webhook.')->group(function () {
    Route::post('/paystack', [PaymentWebhookController::class, 'handle'])->name('paystack');
    Route::post('/flutterwave', [PaymentWebhookController::class, 'handle'])->name('flutterwave');
});

Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
