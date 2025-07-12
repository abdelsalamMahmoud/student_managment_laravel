<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $courses = Course::where('teacher_id', $user->id)->paginate(10);
        return view('frontend.teacher.index',compact('courses'));
    }
}
