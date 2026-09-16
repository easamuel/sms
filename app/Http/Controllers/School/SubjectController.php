<?php

namespace App\Http\Controllers\School;

use App\Models\Sms\SmsSubject;
use Illuminate\Http\Request;

class SubjectController extends BaseSchoolController
{
    public function index()
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }
        
        $subjects = SmsSubject::where('school_id', $school->id)
            ->orderBy('name')
            ->paginate(20);

        return view('school.subjects.index', compact('subjects', 'school'));
    }

    public function store(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        SmsSubject::create([
            'school_id' => $school->id,
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('school.subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    public function bulkCreate(Request $request)
    {
        $school = $this->getSchool();
        
        if (!$school) {
            return redirect()->route('school-management.demo-login')
                ->with('error', 'School not found. Please login again.');
        }

        $request->validate([
            'level' => 'required|in:primary,jss,ss',
        ]);

        $subjects = [];
        $created = 0;
        $skipped = 0;

        switch ($request->level) {
            case 'primary':
                $subjects = [
                    ['name' => 'English Studies', 'code' => 'ENG'],
                    ['name' => 'Mathematics', 'code' => 'MTH'],
                    ['name' => 'Basic Science', 'code' => 'BSC'],
                    ['name' => 'Basic Technology', 'code' => 'BTE'],
                    ['name' => 'Social Studies', 'code' => 'SST'],
                    ['name' => 'Cultural & Creative Arts', 'code' => 'CCA'],
                    ['name' => 'Physical & Health Education', 'code' => 'PHE'],
                    ['name' => 'Christian Religious Studies', 'code' => 'CRS'],
                    ['name' => 'Islamic Studies', 'code' => 'ISL'],
                    ['name' => 'Nigerian Languages', 'code' => 'NLA'],
                    ['name' => 'French', 'code' => 'FRE'],
                    ['name' => 'Arabic', 'code' => 'ARB'],
                ];
                break;

            case 'jss':
                $subjects = [
                    ['name' => 'English Studies', 'code' => 'ENG'],
                    ['name' => 'Mathematics', 'code' => 'MTH'],
                    ['name' => 'Nigerian Languages', 'code' => 'NLA'],
                    ['name' => 'Basic Science', 'code' => 'BSC'],
                    ['name' => 'Physical & Health Education', 'code' => 'PHE'],
                    ['name' => 'Digital Technologies', 'code' => 'DGT'],
                    ['name' => 'Christian Religious Studies', 'code' => 'CRS'],
                    ['name' => 'Islamic Studies', 'code' => 'ISL'],
                    ['name' => 'Nigerian History', 'code' => 'NHS'],
                    ['name' => 'Social and Citizenship Studies', 'code' => 'SCS'],
                    ['name' => 'Cultural & Creative Arts', 'code' => 'CCA'],
                    ['name' => 'Business Studies', 'code' => 'BUS'],
                    ['name' => 'French', 'code' => 'FRE'],
                    ['name' => 'Arabic Language', 'code' => 'ARB'],
                    // Trade Subjects
                    ['name' => 'Solar Photovoltaic Installation and Maintenance', 'code' => 'SPI'],
                    ['name' => 'Fashion Design and Garment Making', 'code' => 'FDM'],
                    ['name' => 'Livestock Farming', 'code' => 'LSF'],
                    ['name' => 'Beauty and Cosmetology', 'code' => 'BCM'],
                    ['name' => 'Computer Hardware and GSM Repairs', 'code' => 'CHR'],
                    ['name' => 'Horticulture and Crop Production', 'code' => 'HCP'],
                ];
                break;

            case 'ss':
                // Core Subjects
                $subjects = [
                    ['name' => 'English Language', 'code' => 'ENG'],
                    ['name' => 'General Mathematics', 'code' => 'MTH'],
                    ['name' => 'Citizenship and Heritage Studies', 'code' => 'CHS'],
                    ['name' => 'Digital Technologies', 'code' => 'DGT'],
                    // Trade Subjects
                    ['name' => 'Solar Photovoltaic Installation and Maintenance', 'code' => 'SPI'],
                    ['name' => 'Fashion Design and Garment Making', 'code' => 'FDM'],
                    ['name' => 'Livestock Farming', 'code' => 'LSF'],
                    ['name' => 'Beauty and Cosmetology', 'code' => 'BCM'],
                    ['name' => 'Computer Hardware and GSM Repairs', 'code' => 'CHR'],
                    ['name' => 'Horticulture and Crop Production', 'code' => 'HCP'],
                    // Science Electives
                    ['name' => 'Biology', 'code' => 'BIO'],
                    ['name' => 'Chemistry', 'code' => 'CHM'],
                    ['name' => 'Physics', 'code' => 'PHY'],
                    ['name' => 'Agriculture', 'code' => 'AGR'],
                    ['name' => 'Further Mathematics', 'code' => 'FMT'],
                    ['name' => 'Physical Education', 'code' => 'PED'],
                    ['name' => 'Health Education', 'code' => 'HED'],
                    ['name' => 'Foods & Nutrition', 'code' => 'FNU'],
                    ['name' => 'Geography', 'code' => 'GEO'],
                    ['name' => 'Technical Drawing', 'code' => 'TDR'],
                    // Humanities Electives
                    ['name' => 'Nigerian History', 'code' => 'NHS'],
                    ['name' => 'Government', 'code' => 'GOV'],
                    ['name' => 'Christian Religious Studies', 'code' => 'CRS'],
                    ['name' => 'Islamic Studies', 'code' => 'ISL'],
                    ['name' => 'French', 'code' => 'FRE'],
                    ['name' => 'Arabic', 'code' => 'ARB'],
                    ['name' => 'Visual Arts', 'code' => 'VSA'],
                    ['name' => 'Music', 'code' => 'MUS'],
                    ['name' => 'Literature in English', 'code' => 'LIT'],
                    ['name' => 'Home Management', 'code' => 'HMG'],
                    ['name' => 'Catering Craft', 'code' => 'CTC'],
                    // Business Electives
                    ['name' => 'Accounting', 'code' => 'ACC'],
                    ['name' => 'Commerce', 'code' => 'COM'],
                    ['name' => 'Marketing', 'code' => 'MKT'],
                    ['name' => 'Economics', 'code' => 'ECO'],
                ];
                break;
        }

        foreach ($subjects as $subjectData) {
            // Check if subject already exists
            $exists = SmsSubject::where('school_id', $school->id)
                ->where('name', $subjectData['name'])
                ->exists();

            if (!$exists) {
                SmsSubject::create([
                    'school_id' => $school->id,
                    'name' => $subjectData['name'],
                    'code' => $subjectData['code'] ?? null,
                    'is_active' => true,
                ]);
                $created++;
            } else {
                $skipped++;
            }
        }

        $message = "Bulk creation completed. {$created} subjects created";
        if ($skipped > 0) {
            $message .= ", {$skipped} subjects already existed and were skipped";
        }
        $message .= ".";

        return redirect()->route('school.subjects.index')
            ->with('success', $message);
    }
}
