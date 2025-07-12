<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Registration;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index()
    {
        $students = User::where('role','student')->count();
        $courses = Course::count();
        $teachers = User::where('role','teacher')->count();
        $enrollments = Registration::count();

        $widget = [
            'students' => $students,
            'courses'=>$courses,
            'teachers'=>$teachers,
            'enrollments'=>$enrollments,
        ];

        return view('dashboard', compact('widget'));
    }
}
