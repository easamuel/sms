<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Stub implementation
        return redirect()->route('school-management.demo-login');
    }

    public function logout(Request $request)
    {
        // Stub implementation
        return redirect('/');
    }
}
