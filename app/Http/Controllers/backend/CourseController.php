<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    protected $role;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->role = auth()->check() ? auth()->user()->role : null;
            return $next($request);
        });
    }

    public function index()
    {
        $courses = Course::with('teacher')->paginate(10);
        return view('dashboard.courses.index', compact('courses'));
    }

    public function create()
    {
        if ($this->role === 'admin') {
            return view('dashboard.courses.create');
        }

        if ($this->role === 'teacher') {
            return view('frontend.teacher.courses.create');
        }

        abort(403);
    }

    public function store(StoreCourseRequest $request)
    {
        try {
            Course::create([
                'title'       => $request->input('title'),
                'description' => $request->input('description'),
                'capacity'    => $request->input('capacity'),
                'teacher_id'  => auth()->user()->id,
            ]);

            if ($this->role === 'admin') {
                return redirect()->route('courses.index')->with('success', 'Course created successfully.');
            }

            if ($this->role === 'teacher') {
                return redirect()->route('teacher.dashboard')->with('success', 'Course created successfully.');
            }
            abort(403);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        if ($this->role === 'admin') {
            return view('dashboard.courses.edit',compact('course'));
        }

        if ($this->role === 'teacher') {
            return view('frontend.teacher.courses.edit',compact('course'));
        }
        abort(403);
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        try {
            $course = Course::findOrFail($id);

            if ($this->role === 'admin') {

                $course->update([
                    'title'       => $request->input('title'),
                    'description' => $request->input('description'),
                    'capacity'    => $request->input('capacity'),
                ]);

                return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
            }

            if ($this->role === 'teacher') {

                if ($course->teacher_id !== auth()->id()) {
                    abort(403, 'You are not allowed to update this course.');
                }

                $course->update([
                    'title'       => $request->input('title'),
                    'description' => $request->input('description'),
                    'capacity'    => $request->input('capacity'),
                ]);

                return redirect()->route('teacher.dashboard')->with('success', 'Course updated successfully.');
            }

            abort(403, 'Unauthorized access.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $course = Course::findOrFail($id);

            if ($this->role === 'admin') {
                $course->delete();
                return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
            }

            if ($this->role === 'teacher') {
                if ($course->teacher_id !== auth()->id()) {
                    abort(403, 'You are not allowed to delete this course.');
                }
                $course->delete();
                return redirect()->route('teacher.dashboard')->with('success', 'Course deleted successfully.');
            }

            abort(403, 'Unauthorized access.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function enrolled_students($course_id)
    {
        $course = Course::with('students')->findOrFail($course_id);

        if ($course->teacher_id !== auth()->user()->id) {
            abort(403, 'You do not have access to this course.');
        }

        return view('frontend.teacher.courses.students',compact('course'));

    }

}
