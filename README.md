# ExtremeSolutions School Management System (ES-Schools)

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![Framework](https://img.shields.io/badge/framework-Laravel_10.x-red.svg)
![PHP](https://img.shields.io/badge/php-8.1%2B-indigo.svg)
![Database](https://img.shields.io/badge/database-MySQL-orange.svg)
![Platform](https://img.shields.io/badge/platform-extremesolutions.com.ng-green.svg)

> **Enterprise School Management & Academic Administration Platform**  
> Engineered by **ExtremeSolutions** ([extremesolutions.com.ng](https://extremesolutions.com.ng)) for nursery, primary, and secondary schools across Nigeria and Africa.  
> *Architected and benchmarked after the industry-leading **Onest Schooled** multi-role school management system.*

---

## 🌟 Executive Summary

**ES-Schools** is a unified, multi-portal School Management System designed to eliminate paper-based record-keeping, streamline academic administration, automate fee collections, provide online computer-based testing (CBT), and foster real-time parent-school collaboration.

Whether deployed for single standalone private institutions or as an educational multi-campus network, ES-Schools delivers a frictionless, reliable experience tailored specifically for the Nigerian curriculum (Basic 1–6, JSS1–JSS3, SS1–SS3, Continuous Assessments CA1/CA2, Termly examinations, and Naira ₦ billing).

---

## 🚀 Key Modules & System Architecture

### 1. 🏫 Super Admin & School Administration Portal (`/school/dashboard`)
* **Student Information**: Student registration, automated ID card generator with printable barcode, profile management, and student promotion.
* **Staff & Teacher Management**: Teacher assignment to classes and curriculum subjects, staff directory, role allocation.
* **Academic Setup**: Class configuration (Basic 1–6, JSS1–SS3), Nigerian curriculum subjects, term management.
* **Timetable & Routines**: Dynamic period-by-period class schedules with conflict prevention.
* **Attendance Management**: Daily roll-call recording, attendance summaries, and percentage calculations.
* **Examinations & CBT**: Exam scheduling, computer-based testing question builder, duration & passing grade configuration.
* **Results & Continuous Assessment (CA)**: CA1, CA2, Termly Exam score entries, cumulative grade calculation, psychomotor assessments, and branded PDF result slips.
* **Fee Collection & Payments**: Fee structures (Tuition, Development levy, Sports, Library), payment tracking, Paystack / Flutterwave integration, and manual bank transfer proof approvals.
* **School Communications**: Automated notice board and two-way parent-school messaging system.

### 2. 👨‍🏫 Teacher Portal (`/sms/teacher/dashboard`)
* Dedicated dashboard with active class allocations and assigned subjects.
* Daily attendance marking for assigned classrooms.
* Question bank manager: Create CBT questions or batch upload via CSV templates.
* Comprehensive Marks Entry & Grade Book: CA1, CA2, Exam, and psychomotor behavioral traits.
* Assignment creation and student homework submissions.
* Live timetable viewer and school broadcast notices.

### 3. 🎓 Student CBT & Academic Portal (`/sms/student/dashboard`)
* Personalized student dashboard with term progress and announcements.
* CBT Examination Hall: Timed, interactive online assessments with instant result calculation.
* Practice Sessions: Interactive practice drills by subject.
* Academic Result Slips: Termly report card breakdown with grading scales and teacher remarks.
* Class Timetable & Attendance Calendar.
* Fee Status Tracker: Termly fee invoice summary and balance clearance checks (with exam clearance gating).

### 4. 👨‍👩‍👧 Parent Collaboration Portal (`/sms/parent/dashboard`)
* Multi-Child Switcher: Instant overview of all enrolled children under one account.
* Real-Time Attendance & Academic Performance: View children's attendance history and termly report cards.
* Secure Fee Payments: Instant payment via Paystack gateway or manual bank transfer receipt upload.
* Direct Teacher & Admin Messaging: Threaded communication with school management.

---

## 🔑 Demo & Pitch Access (1-Click Instant Login)

For prospective school demos and pitches, the login interface (`/login` and `/school-management/demo-login`) includes **1-Click Demo Buttons** matching the Onest Schooled live demo experience.

| Role | Demo Username / Email | Password | Direct Portal |
| :--- | :--- | :--- | :--- |
| 🏫 **School Administrator** | `admin@demo.com` | `demo123` | `/school/dashboard` |
| 👨‍🏫 **Teacher** | `teacher@demo.com` | `demo123` | `/sms/teacher/dashboard` |
| 🎓 **Student** | `ade.adebayo@student.demo.com` *(or `STU-00001`)* | `demo123` | `/sms/student/dashboard` |
| 👨‍👩‍👧 **Parent** | `parent@demo.com` | `demo123` | `/sms/parent/dashboard` |

---

## 💻 Tech Stack & Standards

- **Core Framework**: Laravel 10.x
- **Language**: PHP 8.1+
- **Database Engine**: MySQL 5.7+ / 8.0+ / MariaDB
- **Frontend Architecture**: Modern Blade components, Vanilla JavaScript, CSS custom properties, Google Fonts (Poppins & Inter), FontAwesome 6
- **Payment Gateways**: Paystack, Flutterwave, Manual Bank Transfer verification
- **Security**: CSRF protection on all forms, hashed credentials (bcrypt), strict session isolation, role-based authorization middleware (`sms.auth`)

---

## 🛠️ Installation & Setup Guide

### 1. Requirements
Ensure your server or development environment has:
- PHP >= 8.1 (with `pdo_mysql`, `curl`, `mbstring`, `openssl`, `xml`, `zip`, `gd`)
- MySQL / MariaDB Server
- Composer 2.x

### 2. Environment Configuration
Verify your `.env` configuration:
```env
APP_NAME="ExtremeSolutions School Management System"
APP_ENV=local
APP_KEY=base64:fVy21PZlToNYh0W0W8fnQwCcmfix5r+wRlHNj24dI4U=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sms_system
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Database Migration & Seeding
Run migrations and populate comprehensive pitch demo data:
```bash
# Run all database migrations
php artisan migrate

# Seed Nigerian curriculum classes, subjects, demo exams, results, and accounts
php artisan db:seed --class=SmsDemoDataSeeder
```

### 4. Storage Link & Cache Refresh
```bash
php artisan storage:link
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 5. Launch Local Development Server
```bash
php artisan serve
```
Open **`http://localhost:8000`** in your browser:
- **Public Landing Page**: `http://localhost:8000/`
- **1-Click Pitch Demo Login**: `http://localhost:8000/login`
- **Demo Role Switcher**: `http://localhost:8000/school-management/demo-login`

---

## 📁 Clean Directory Layout

```
SMS_EXTRACTED/
├── app/
│   ├── Http/Controllers/
│   │   ├── School/               # Admin portal controllers (Students, Staff, Fees, Exams)
│   │   ├── Sms/                  # Portal controllers (Teacher, Student, Parent, CBT)
│   │   ├── Payment/              # Paystack & Flutterwave controllers & webhooks
│   │   └── SchoolManagementController.php  # Public marketing & role auth router
│   ├── Models/Sms/               # Eloquent domain models (School, Student, Fee, Exam, etc.)
│   ├── Observers/                # Model business rule observers
│   └── Providers/                # Standard Laravel providers (AppServiceProvider, RouteServiceProvider)
├── config/                       # Application configuration
├── database/
│   ├── migrations/               # Database migrations (47 completed schema migrations)
│   └── seeders/                  # SmsDemoDataSeeder with Nigerian curriculum data
├── docs/                         # Documentation & pitch guides
│   ├── PITCH_GUIDE.md            # School sales & demonstration guide
│   └── archive/                  # Archived setup & migration notes
├── public/                       # Web document root
├── resources/
│   └── views/
│       ├── layouts/              # Admin & portal master layouts
│       ├── school/               # School administration view templates
│       ├── sms/                  # Teacher, Student, and Parent portal views
│       ├── school-management/    # Authorized login & 1-click demo switcher views
│       └── landing.blade.php     # High-conversion public presentation page
├── routes/
│   ├── web.php                   # All 170+ application web routes cleanly mapped
│   └── api.php                   # REST API routes
└── storage/                      # File uploads, sessions, and logs
```

---

## 🤝 Commercial Support & Customization

Developed and maintained by **ExtremeSolutions**.  
Website: [extremesolutions.com.ng](https://extremesolutions.com.ng)  
Support: `help@extremesolutions.com.ng`
