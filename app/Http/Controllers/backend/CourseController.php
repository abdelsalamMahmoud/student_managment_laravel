<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('teacher')->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(StoreCourseRequest $request)
    {
        try{
            Course::create([
                'title'=>$request->input('title'),
                'description'=>$request->input('description'),
                'capacity'=>$request->input('capacity'),
                'teacher_id'=>auth()->user()->id,
            ]);
            return redirect()->route('courses.index');
        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit',compact('course'));
    }

    public function update(UpdateCourseRequest $request , $id)
    {
        try{
            $post = Course::findOrFail($id);
            $post->update([
                'title'=>$request->input('title'),
                'description'=>$request->input('description'),
                'capacity'=>$request->input('capacity'),
            ]);
            return redirect()->route('courses.index');
        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function delete($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();
            return redirect()->route('courses.index');
        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
