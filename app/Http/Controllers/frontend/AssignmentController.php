<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssignmentRequest;
use App\Models\File;

class AssignmentController extends Controller
{
    public function create($course_id)
    {
        return view('frontend.teacher.create-assignment',compact('course_id'));

    }

    public function store(StoreAssignmentRequest $request,$course_id)
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
