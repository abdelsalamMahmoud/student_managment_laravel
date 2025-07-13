<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradeRequest;
use App\Models\Course;
use App\Models\Grade;
use App\Models\User;

class GradeController extends Controller
{
    public function create($student_id,$course_id)
    {
        $student = User::findOrFail($student_id);
        $course = Course::findOrFail($course_id);
        return view('frontend.teacher.add-grade',compact('student','course'));
    }

    public function store(StoreGradeRequest $request , $student_id , $course_id)
    {
        try {
            Grade::create([
                'value' => $request->input('value'),
                'student_id'  => $student_id,
                'course_id'  => $course_id,
            ]);
            return redirect()->back()->with('success', 'Grade Added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
