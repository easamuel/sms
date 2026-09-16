<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmsLogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Clear SMS session
        $request->session()->forget(['sms_user_id', 'sms_role', 'sms_user']);

        return redirect()->route('school-management.index')
            ->with('success', 'You have been logged out successfully.');
    }
}

