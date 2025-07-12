<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
    public function index()
    {
        return view('frontend.teacher.index');
    }
}
