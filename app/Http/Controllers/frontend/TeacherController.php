<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Course;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $courses = Course::where('teacher_id', $user->id)->paginate(10);
        return view('frontend.teacher.index',compact('courses'));
    }

    public function create_assignment($course_id)
    {
        return view('frontend.teacher.create-assignment',compact('course_id'));

    }

    public function store_assignment(StoreAssignmentRequest $request,$course_id)
    {
        try {
            $uploadedFile = $request->file('file');
            $fileName = time() . '_' . $uploadedFile->getClientOriginalName();

            $filePath = $uploadedFile->storeAs('assignments', $fileName, 'public');

            File::create([
                'name'       => $request->input('title'),
                'path'       => $filePath,
                'teacher_id' => auth()->id(),
                'course_id'  => $course_id,
            ]);

            return redirect()->route('teacher.dashboard')
                ->with('success', 'Assignment uploaded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
