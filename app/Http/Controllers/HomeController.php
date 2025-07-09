<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index()
    {
        $users = User::count();
        $courses = Course::count();

        $widget = [
            'users' => $users,
            'courses'=>$courses,
        ];

        return view('dashboard', compact('widget'));
    }
}
