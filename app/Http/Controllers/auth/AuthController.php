<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login', [
            'title' =>  'Login',
            'js'    =>  ['assets/js/apps/auth/login.js']
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $credentials['is_locked'] = false;

        if (Auth::attempt($credentials, $request->rememberMe)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->with([
            'alert' => 'Username/Password is wrong. Please contact Administrator from GMBalindo',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'data'  =>  [
                'status'    =>  true,
                'url'       =>  url('/login')
            ]
        ]);
    }
}
