<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;

class BaseSchoolController extends Controller
{
    /**
     * Get the school for SMS admin - REQUIRED: Every admin must have a school_id
     * This is a standalone SMS system - no LearnersCom dependencies
     */
    protected function getSchool()
    {
        // Get SMS user from session
        $smsUser = session('sms_user');
        
        if (!$smsUser) {
            $smsUserId = session('sms_user_id');
            if ($smsUserId) {
                $smsUser = \App\Models\Sms\SmsUser::find($smsUserId);
                if ($smsUser) {
                    session(['sms_user' => $smsUser, 'sms_role' => $smsUser->role]);
                }
            }
        }
        
        if (!$smsUser) {
            // Auto-resolve demo admin if session was lost
            $smsUser = \App\Models\Sms\SmsUser::where('role', 'admin')->first();
            if ($smsUser) {
                session([
                    'sms_user_id' => $smsUser->id,
                    'sms_role' => 'admin',
                    'sms_user' => $smsUser,
                ]);
            }
        }

        if (!$smsUser) {
            return \App\Models\Sms\SmsSchool::where('name', 'Excellence Secondary School')->first()
                ?? \App\Models\Sms\SmsSchool::first();
        }

        // If user has school_id, get the school
        if ($smsUser->school_id) {
            $school = \App\Models\Sms\SmsSchool::find($smsUser->school_id);
            if ($school) {
                return $school;
            }
        }

        // If no school_id, ensure admin gets assigned to a school
        $school = $this->ensureSchoolForAdmin($smsUser);
        return $school;
    }

    /**
     * Ensure admin user has a school assigned
     */
    protected function ensureSchoolForAdmin($smsUser)
    {
        // Try to get seeded school first
        $school = \App\Models\Sms\SmsSchool::where('name', 'Excellence Secondary School')->first();
        
        if (!$school) {
            // Create demo school if doesn't exist
            $school = \App\Models\Sms\SmsSchool::firstOrCreate(
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
        }

        // Update user with school_id
        $smsUser->update(['school_id' => $school->id]);
        
        // Update session
        session(['sms_user' => $smsUser->fresh()]);

        return $school;
    }

    /**
     * Get school ID safely
     */
    protected function getSchoolId()
    {
        $school = $this->getSchool();
        return $school ? $school->id : null;
    }
}
