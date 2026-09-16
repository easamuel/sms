<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sms\SmsSchool;
use App\Models\Sms\SmsUser;
use App\Models\Sms\SmsClass;
use App\Models\Sms\SmsSubject;
use App\Models\Sms\SmsTeacher;
use App\Models\Sms\SmsStudent;
use App\Models\Sms\SmsParent;
use App\Models\Sms\Timetable;
use App\Models\Sms\SmsExam;
use App\Models\Sms\SmsExamQuestion;
use App\Models\Sms\Result;
use App\Models\Sms\SmsFee;
use App\Models\Sms\StudentFee;
use App\Models\Sms\SmsAttendance;
use App\Models\Sms\SmsNotice;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class SmsDemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $currentYear = date('Y');
        
        // Create Demo School
        $school = SmsSchool::firstOrCreate(
            ['name' => 'Excellence Secondary School'],
            [
                'registration_number' => 'ESS-2024-001',
                'school_type' => 'Secondary',
                'address' => '123 Education Avenue',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'country' => 'Nigeria',
                'phone' => '+234 801 234 5678',
                'email' => 'info@excellenceschool.ng',
                'website' => 'https://excellenceschool.ng',
                'is_active' => true,
            ]
        );

        // Create Nigerian Classes (Basic 1-6, JSS1-SS3) - NO SECTIONS
        $classes = [];
        $classNames = ['Basic 1', 'Basic 2', 'Basic 3', 'Basic 4', 'Basic 5', 'Basic 6', 'JSS1', 'JSS2', 'JSS3', 'SS1', 'SS2', 'SS3'];

        foreach ($classNames as $className) {
            $classes[$className] = SmsClass::firstOrCreate(
                [
                    'school_id' => $school->id,
                    'name' => $className,
                ],
                [
                    'academic_year' => date('Y'),
                    'capacity' => 40,
                ]
            );
        }

        // Create Subjects
        $subjects = [];
        $subjectNames = [
            'Mathematics', 'English Language', 'Physics', 'Chemistry', 'Biology',
            'Economics', 'Government', 'Literature', 'Geography', 'History',
            'Agricultural Science', 'Computer Studies', 'French', 'Yoruba',
        ];

        foreach ($subjectNames as $subjectName) {
            $subjects[$subjectName] = SmsSubject::firstOrCreate(
                [
                    'school_id' => $school->id,
                    'name' => $subjectName,
                ],
                [
                    'code' => strtoupper(substr($subjectName, 0, 3)),
                    'is_active' => true,
                ]
            );
        }

        // Create Admin User
        $adminUser = SmsUser::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'School Administrator',
                'password' => Hash::make('demo123'),
                'role' => 'admin',
                'school_id' => $school->id,
                'is_active' => true,
            ]
        );

        // Create Teachers
        $teachers = [];
        $teacherData = [
            ['name' => 'Mr. Adebayo Ojo', 'email' => 'teacher@demo.com', 'subjects' => ['Mathematics', 'Physics'], 'classes' => ['JSS2', 'SS1']],
            ['name' => 'Mrs. Chioma Okoro', 'email' => 'chioma@demo.com', 'subjects' => ['English Language', 'Literature'], 'classes' => ['JSS1', 'SS2']],
            ['name' => 'Dr. Ibrahim Musa', 'email' => 'ibrahim@demo.com', 'subjects' => ['Chemistry', 'Biology'], 'classes' => ['SS1', 'SS2']],
            ['name' => 'Miss Funke Adeleke', 'email' => 'funke@demo.com', 'subjects' => ['Economics', 'Government'], 'classes' => ['SS1', 'SS2']],
        ];

        foreach ($teacherData as $index => $teacherInfo) {
            $teacherUser = SmsUser::firstOrCreate(
                ['email' => $teacherInfo['email']],
                [
                    'name' => $teacherInfo['name'],
                    'password' => Hash::make('demo123'),
                    'role' => 'teacher',
                    'school_id' => $school->id,
                    'is_active' => true,
                ]
            );

            $teacher = SmsTeacher::firstOrCreate(
                ['user_id' => $teacherUser->id],
                [
                    'school_id' => $school->id,
                    'employee_id' => 'TCH-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'qualification' => $index === 2 ? 'Ph.D' : 'B.Ed',
                    'specialization' => $teacherInfo['subjects'][0],
                    'hire_date' => Carbon::now()->subMonths(rand(6, 24)),
                    'status' => 'active',
                ]
            );

            // Attach subjects to teacher
            foreach ($teacherInfo['subjects'] as $subjectName) {
                if (isset($subjects[$subjectName])) {
                    $teacher->subjects()->syncWithoutDetaching([$subjects[$subjectName]->id]);
                }
            }

            // Assign as class teacher (remove 'A' suffix if present)
            foreach ($teacherInfo['classes'] as $className) {
                $classKey = str_replace('A', '', $className);
                if (isset($classes[$classKey])) {
                    $classes[$classKey]->update(['class_teacher_id' => $teacher->id]);
                }
            }

            $teachers[] = $teacher;
        }

        // Create Students
        $students = [];
        $firstNames = ['Ade', 'Chukwu', 'Ibrahim', 'Fatima', 'Emeka', 'Amina', 'Oluwaseun', 'Ngozi', 'Hassan', 'Blessing'];
        $lastNames = ['Adebayo', 'Okoro', 'Musa', 'Ibrahim', 'Okafor', 'Adeleke', 'Okafor', 'Nwosu', 'Aliyu', 'Obi'];

        foreach ($classes as $classKey => $class) {
            for ($i = 1; $i <= 15; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $fullName = "{$firstName} {$lastName}";
                $email = strtolower($firstName . '.' . $lastName . '@student.demo.com');

                $studentUser = SmsUser::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $fullName,
                        'password' => Hash::make('demo123'),
                        'role' => 'student',
                        'school_id' => $school->id,
                        'is_active' => true,
                    ]
                );

                $student = SmsStudent::firstOrCreate(
                    ['user_id' => $studentUser->id],
                    [
                        'school_id' => $school->id,
                        'student_id_number' => 'STU-' . str_pad($studentUser->id, 5, '0', STR_PAD_LEFT),
                        'class_id' => $class->id,
                        'admission_date' => Carbon::now()->subMonths(rand(1, 12)),
                        'date_of_birth' => Carbon::now()->subYears(rand(13, 18)),
                        'gender' => rand(0, 1) ? 'male' : 'female',
                        'status' => 'active',
                    ]
                );

                $students[] = $student;
            }
        }

        // Create Parents
        $parentUser = SmsUser::firstOrCreate(
            ['email' => 'parent@demo.com'],
            [
                'name' => 'Mr. & Mrs. Demo Parent',
                'password' => Hash::make('demo123'),
                'role' => 'parent',
                'school_id' => $school->id,
                'is_active' => true,
            ]
        );

        $parent = SmsParent::firstOrCreate(
            ['user_id' => $parentUser->id],
            [
                'school_id' => $school->id,
                'occupation' => 'Business',
                'relationship' => 'parent',
            ]
        );

        // Clean existing parent links to respect the 2-child limit enforced by SmsStudentObserver
        \Illuminate\Support\Facades\DB::table('sms_students')
            ->where('parent_id', $parent->id)
            ->update(['parent_id' => null]);
            
        \Illuminate\Support\Facades\DB::table('parent_student')
            ->where('parent_id', $parent->id)
            ->delete();

        // Link exactly 2 students to demo parent
        $studentsToLink = array_slice($students, 0, 2);
        foreach ($studentsToLink as $student) {
            $student->update(['parent_id' => $parent->id]);
        }

        // Create Timetables
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $timeSlots = [
            ['08:00', '08:40'],
            ['08:40', '09:20'],
            ['09:20', '10:00'],
            ['10:20', '11:00'],
            ['11:00', '11:40'],
            ['11:40', '12:20'],
            ['12:20', '13:00'],
        ];

        foreach ($classes as $classKey => $class) {
            foreach ($days as $day) {
                $slotIndex = 0;
                foreach ($timeSlots as $timeSlot) {
                    if ($slotIndex < count($subjects)) {
                        $subjectKeys = array_keys($subjects);
                        $subject = $subjects[$subjectKeys[$slotIndex % count($subjectKeys)]];
                        
                        // Find teacher for this subject
                        $teacher = $teachers[array_rand($teachers)];
                        
                        Timetable::firstOrCreate(
                            [
                                'school_id' => $school->id,
                                'class_id' => $class->id,
                                'subject_id' => $subject->id,
                                'teacher_id' => $teacher->id,
                                'day' => $day,
                                'academic_year' => date('Y'),
                            ],
                            [
                                'start_time' => $timeSlot[0],
                                'end_time' => $timeSlot[1],
                                'period_number' => 'Period ' . ($slotIndex + 1),
                                'term' => 'First Term',
                                'is_active' => true,
                            ]
                        );
                    }
                    $slotIndex++;
                }
            }
        }

        // Create Exams
        $examTypes = ['CA1', 'CA2', 'Test', 'Exam'];
        $examSubjects = ['Mathematics', 'English Language', 'Physics', 'Chemistry', 'Biology'];

        foreach ($classes as $classKey => $class) {
            foreach ($examTypes as $examType) {
                foreach ($examSubjects as $subjectName) {
                    if (!isset($subjects[$subjectName])) continue;

                    // Create one exam scheduled for today (for demo purposes)
                    $isTodayExam = ($classKey === 'JSS1' && $examType === 'CA1' && $subjectName === 'Mathematics');
                    $scheduledDate = $isTodayExam ? Carbon::today() : Carbon::now()->addDays(rand(1, 30));

                    $exam = SmsExam::firstOrCreate(
                        [
                            'school_id' => $school->id,
                            'class_id' => $class->id,
                            'subject_id' => $subjects[$subjectName]->id,
                            'name' => "{$examType} - {$subjectName}",
                        ],
                        [
                            'title' => "{$examType} - {$subjectName}",
                            'exam_type' => $examType,
                            'teacher_id' => $teachers[0]->id,
                            'start_date' => $scheduledDate,
                            'scheduled_date' => $scheduledDate,
                            'scheduled_time' => '10:00',
                            'duration_minutes' => $examType === 'Exam' ? 120 : 60,
                            'total_questions' => $examType === 'Exam' ? 50 : 25,
                            'total_marks' => $examType === 'Exam' ? 100 : 50,
                            'passing_score' => 50,
                            'is_active' => true,
                        ]
                    );

                    // Create exam questions with proper content
                    $questionCount = $examType === 'Exam' ? 10 : 5;
                    for ($q = 1; $q <= $questionCount; $q++) {
                        $questionText = $this->generateQuestionText($subjectName, $q);
                        $options = $this->generateQuestionOptions($subjectName, $q);
                        $correctAnswer = $options[0]; // First option is correct for demo

                        SmsExamQuestion::firstOrCreate(
                            [
                                'exam_id' => $exam->id,
                                'order' => $q,
                            ],
                            [
                                'question_text' => $questionText,
                                'question_type' => 'multiple_choice',
                                'options' => json_encode($options),
                                'correct_answer' => $correctAnswer,
                                'points' => 1,
                            ]
                        );
                    }
                }
            }
        }

        // Create Demo Exam Results (from completed exam sessions)
        // Results will be created automatically when students complete exams via SmsExamSession
        // But we'll create one demo result for demonstration
        $demoStudent = $students[0] ?? null;
        $demoMathSubject = $subjects['Mathematics'] ?? null;
        
        if ($demoStudent && $demoMathSubject) {
            // Find the demo exam (CA1 Mathematics for JSS1)
            $demoExam = SmsExam::where('school_id', $school->id)
                ->where('class_id', $classes['JSS1']->id ?? $classes['Basic 1']->id ?? null)
                ->where('subject_id', $demoMathSubject->id)
                ->where('exam_type', 'CA1')
                ->first();
            
            if ($demoExam) {
                // Create a completed exam session with result
                $demoSession = \App\Models\Sms\SmsExamSession::firstOrCreate(
                    [
                        'exam_id' => $demoExam->id,
                        'student_id' => $demoStudent->id,
                    ],
                    [
                        'status' => 'completed',
                        'started_at' => Carbon::now()->subDays(2),
                        'ended_at' => Carbon::now()->subDays(2)->addMinutes(60),
                        'submitted_at' => Carbon::now()->subDays(2)->addMinutes(60),
                        'score' => 65,
                        'total_score' => 100,
                        'percentage' => 65.00,
                        'passed' => true,
                    ]
                );

                // Create result record if table exists
                if (Schema::hasTable('sms_exam_results')) {
                    \App\Models\Sms\SmsExamResult::firstOrCreate(
                        [
                            'exam_id' => $demoExam->id,
                            'student_id' => $demoStudent->id,
                        ],
                        [
                            'school_id' => $school->id,
                            'marks_obtained' => 65,
                            'grade' => 'C',
                            'remarks' => 'Good performance',
                        ]
                    );
                }
            }
        }

        // Create Fees
        $feeTypes = [
            ['name' => 'Tuition Fee', 'amount' => 50000],
            ['name' => 'Development Levy', 'amount' => 10000],
            ['name' => 'Library Fee', 'amount' => 5000],
            ['name' => 'Sports Fee', 'amount' => 3000],
        ];

        foreach ($classes as $class) {
            foreach ($feeTypes as $feeType) {
                $fee = SmsFee::firstOrCreate(
                    [
                        'school_id' => $school->id,
                        'class_id' => $class->id,
                        'name' => $feeType['name'],
                    ],
                    [
                        'amount' => $feeType['amount'],
                        'due_date' => Carbon::now()->addMonths(1),
                        'academic_year' => $currentYear,
                        'is_active' => true,
                    ]
                );

                // Assign fees to students
                foreach ($students as $student) {
                    if ($student->class_id === $class->id) {
                        $paidAmount = rand(0, $fee->amount);
                        $balance = $fee->amount - $paidAmount;
                        
                        $studentFee = StudentFee::firstOrCreate(
                            [
                                'student_id' => $student->id,
                                'fee_id' => $fee->id,
                            ],
                            [
                                'school_id' => $school->id,
                                'amount' => $fee->amount,
                                'paid_amount' => $paidAmount,
                                'balance' => $balance,
                                'status' => $balance <= 0 ? 'paid' : ($paidAmount > 0 ? 'partial' : 'pending'),
                                'due_date' => $fee->due_date,
                            ]
                        );

                        if ($paidAmount > 0) {
                            \App\Models\Sms\SmsFeePayment::firstOrCreate(
                                [
                                    'student_fee_id' => $studentFee->id,
                                ],
                                [
                                    'school_id' => $school->id,
                                    'fee_id' => $fee->id,
                                    'student_id' => $student->id,
                                    'amount_paid' => $paidAmount,
                                    'payment_date' => Carbon::now()->subDays(rand(1, 45)),
                                    'payment_method' => 'bank_transfer',
                                    'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                                    'receipt_number' => 'REC-' . strtoupper(uniqid()),
                                    'receipt_generated' => true,
                                    'payment_status' => 'successful',
                                ]
                            );
                        }
                    }
                }
            }
        }

        // Create Attendance Records
        $startDate = Carbon::now()->subDays(30);
        foreach ($students as $student) {
            for ($day = 0; $day < 20; $day++) {
                $date = $startDate->copy()->addDays($day);
                if ($date->isWeekend()) continue;

                // Use updateOrCreate to avoid duplicates
                SmsAttendance::updateOrCreate(
                    [
                        'school_id' => $school->id,
                        'student_id' => $student->id,
                        'class_id' => $student->class_id,
                        'date' => $date->format('Y-m-d'),
                    ],
                    [
                        'status' => rand(0, 10) > 1 ? 'present' : 'absent',
                        'remarks' => null,
                    ]
                );
            }
        }

        // Create Demo Notices
        $demoNotices = [
            [
                'title' => 'First Term Continuous Assessment (CA1) Schedule',
                'content' => 'All teachers are advised to ensure all CA1 test questions are uploaded to the CBT portal by Friday. The examination window opens on Monday for all junior and senior classes.',
                'target_audience' => 'all',
                'published_at' => Carbon::now()->subDays(2),
                'expires_at' => Carbon::now()->addDays(14),
                'is_active' => true,
            ],
            [
                'title' => 'Staff Academic Review & Lesson Plan Submission',
                'content' => 'Reminder to all subject teachers: Week 4 lesson notes and psychomotor evaluation sheets are due for submission to the Vice Principal Academics.',
                'target_audience' => 'teachers',
                'published_at' => Carbon::now()->subDays(1),
                'expires_at' => Carbon::now()->addDays(7),
                'is_active' => true,
            ],
            [
                'title' => 'Upcoming PTA Meeting & Termly Fee Clearance',
                'content' => 'Dear Parents and Guardians, the first general PTA meeting of the term holds next Saturday at 10:00 AM in the school auditorium. Kindly ensure school fee receipts are verified.',
                'target_audience' => 'parents',
                'published_at' => Carbon::now()->subDays(3),
                'expires_at' => Carbon::now()->addDays(20),
                'is_active' => true,
            ],
        ];

        foreach ($demoNotices as $noticeData) {
            SmsNotice::firstOrCreate(
                [
                    'school_id' => $school->id,
                    'title' => $noticeData['title'],
                ],
                $noticeData
            );
        }

        $this->command->info('SMS Demo Data Seeded Successfully!');
        $this->command->info("School: {$school->name}");
        $this->command->info("Classes: " . count($classes));
        $this->command->info("Students: " . count($students));
        $this->command->info("Teachers: " . count($teachers));
    }

    private function calculateGrade($score): string
    {
        if ($score >= 75) return 'A';
        if ($score >= 70) return 'B';
        if ($score >= 65) return 'C';
        if ($score >= 60) return 'D';
        if ($score >= 50) return 'E';
        return 'F';
    }

    private function calculateRemark($score): string
    {
        $grade = $this->calculateGrade($score);
        return match($grade) {
            'A' => 'Excellent',
            'B' => 'Very Good',
            'C' => 'Good',
            'D' => 'Credit',
            'E' => 'Pass',
            default => 'Fail',
        };
    }

    private function generateQuestionText($subject, $number)
    {
        $questions = [
            'Mathematics' => [
                "What is 2 + 2?",
                "What is 5 × 3?",
                "What is 10 ÷ 2?",
                "What is the square root of 16?",
                "What is 3²?",
            ],
            'English Language' => [
                "What is the past tense of 'go'?",
                "Which word is a noun: run, quickly, or book?",
                "What is the plural of 'child'?",
                "Which sentence is correct?",
                "What is a synonym for 'happy'?",
            ],
            'Physics' => [
                "What is the unit of force?",
                "What is the speed of light?",
                "What is Newton's first law?",
                "What is the formula for velocity?",
                "What is acceleration?",
            ],
            'Chemistry' => [
                "What is the chemical symbol for water?",
                "What is the atomic number of carbon?",
                "What is pH?",
                "What is a molecule?",
                "What is the periodic table?",
            ],
            'Biology' => [
                "What is the powerhouse of the cell?",
                "What is photosynthesis?",
                "What is DNA?",
                "What is the largest organ in the human body?",
                "What is the function of the heart?",
            ],
        ];

        $subjectQuestions = $questions[$subject] ?? ["Question {$number} for {$subject}"];
        $index = ($number - 1) % count($subjectQuestions);
        return $subjectQuestions[$index];
    }

    private function generateQuestionOptions($subject, $number)
    {
        // Generate 4 options, with first one being correct
        $baseOptions = [
            ['A) 4', 'B) 5', 'C) 6', 'D) 7'],
            ['A) 15', 'B) 12', 'C) 18', 'D) 20'],
            ['A) 5', 'B) 4', 'C) 6', 'D) 8'],
            ['A) 4', 'B) 8', 'C) 2', 'D) 16'],
            ['A) 9', 'B) 6', 'C) 12', 'D) 15'],
        ];

        $index = ($number - 1) % count($baseOptions);
        return $baseOptions[$index];
    }
}
