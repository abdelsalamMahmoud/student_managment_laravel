<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseApiRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use ApiResopnseTrait;

//    protected $role;

//    public function __construct()
//    {
//        $this->middleware(function ($request, $next) {
//            $this->role = auth()->check() ? auth()->user()->role : null;
//            return $next($request);
//        });
//    }

    public function index()
    {
        $courses = CourseResource::collection(Course::with('teacher')->paginate(10));
        return $this->apiResponse($courses, 'These are all courses', 200);
    }

    public function show($id)
    {
        try {
            $course = new CourseResource(Course::findOrFail($id));
            return $this->apiResponse($course, 'This is the course', 200);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function store(StoreCourseRequest $request)
    {
        try {
            $course = Course::create([
                'title'       => $request->title,
                'description' => $request->description,
                'capacity'    => $request->capacity,
                'teacher_id'  => 1,
            ]);
            return $this->apiResponse($course, 'course created successfully', 201);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(UpdateCourseApiRequest $request, $id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->update([
                    'title'       => $request->title,
                    'description' => $request->description,
                    'capacity'    => $request->capacity,
            ]);

            return $this->apiResponse($course, 'course updated successfully', 200);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();
            return $this->apiResponse(null, 'course deleted successfully', 200);
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
