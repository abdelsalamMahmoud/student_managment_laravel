<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function redirectTo()
    {
        $user = Auth::user();
        session()->flash('success', 'You are logged in!');

        // Role-based redirection
        switch ($user->role) {
            case 'admin':
                return route('home');
            case 'teacher':
                return route('teacher.dashboard');
            case 'student':
                return route('student.dashboard');
            default:
                return '/';
        }
    }
}
