<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Student Login Page
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Login Page
    |--------------------------------------------------------------------------
    */

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }


    /*
    |--------------------------------------------------------------------------
    | Student Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (
            Auth::attempt(
                $credentials,
                $request->boolean('remember')
            )
        ) {

            $request->session()->regenerate();


            /*
            |--------------------------------------------------------------------------
            | Prevent Admin from using Student Login
            |--------------------------------------------------------------------------
            */

            if (Auth::user()->role === 'admin') {

                Auth::logout();

                return back()
                    ->withErrors([
                        'email' => 'Please use the Admin Login page.',
                    ])
                    ->onlyInput('email');
            }


            /*
            |--------------------------------------------------------------------------
            | Student Dashboard
            |--------------------------------------------------------------------------
            */

            return redirect()->route('students.dashboard');
        }


        return back()
            ->withErrors([
                'email' => 'The provided email or password is incorrect.',
            ])
            ->onlyInput('email');
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Login
    |--------------------------------------------------------------------------
    */

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (
            Auth::attempt(
                $credentials,
                $request->boolean('remember')
            )
        ) {

            $request->session()->regenerate();


            /*
            |--------------------------------------------------------------------------
            | Only Admin Can Enter Admin Panel
            |--------------------------------------------------------------------------
            */

            if (Auth::user()->role !== 'admin') {

                Auth::logout();

                return back()
                    ->withErrors([
                        'email' => 'You are not authorized to access the Admin Panel.',
                    ])
                    ->onlyInput('email');
            }


            /*
            |--------------------------------------------------------------------------
            | Admin Dashboard
            |--------------------------------------------------------------------------
            */

            return redirect()->route('admin.dashboard');
        }


        return back()
            ->withErrors([
                'email' => 'The provided email or password is incorrect.',
            ])
            ->onlyInput('email');
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
