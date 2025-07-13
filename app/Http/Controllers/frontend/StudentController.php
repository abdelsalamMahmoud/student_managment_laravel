<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\File;
use App\Models\Registration;

class StudentController extends Controller
{
    public function index()
    {
        $studentId = auth()->id();

        $courses = Course::with('teacher')
            ->whereDoesntHave('registrations', function ($query) use ($studentId) {
                $query->where('student_id', $studentId);
            })
            ->paginate(10);

        return view('frontend.student.index', compact('courses'));
    }

    public function get_enrolled_courses()
    {
        $registrations = Registration::where('student_id',auth()->user()->id)->with('course')->paginate(10);
        return view('frontend.student.my-courses',compact('registrations'));
    }

    public function enroll_course($course_id)
    {
        try {
            $course = Course::findOrFail($course_id);

            if ($course->isFull()) {
                return redirect()->back()->withErrors(['error' => 'This course is already full.']);
            }

            Registration::create([
                'student_id' => auth()->user()->id,
                'course_id'  => $course_id,
            ]);

            return redirect()->route('student.courses')->with('success', 'You enrolled in the course successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function get_assignments($course_id)
    {
        $course = Course::findOrFail($course_id);

        $isEnrolled = auth()->user()->registrations()->where('course_id', $course_id)->exists();

        if (! $isEnrolled) {
            abort(403, 'You are not enrolled in this course.');
        }

        $assignments = File::where('course_id', $course_id)->paginate(10);

        return view('frontend.student.assignments',compact('course','assignments'));
    }
}
