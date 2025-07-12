<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index()
    {
        return view('frontend.student.index');
    }
}
