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
        $courses = CourseResource::collection(Course::with('teacher')->paginate(10));
        if(!$courses)
        {
            return $this->apiResponse(null, 'There are no courses', 203);
        }
        return $this->apiResponse($courses, 'These are all courses', 200);
    }

    public function show($id)
    {
        try {
            $course = new CourseResource(Course::findOrFail($id));
            return $this->apiResponse($course, 'This is the course', 200);
        } catch (\Exception $e) {
            return $this->apiResponse(null, 'something went wrong', 500);
        }
    }

    public function store(StoreCourseRequest $request)
    {
        try {
            $data = $request->except(['_token']);
            $data['teacher_id'] = auth()->user()->id;
            $course = Course::create($data);
            return $this->apiResponse($course, 'course created successfully', 201);
        } catch (\Exception $e) {
            return $this->apiResponse(null, 'something went wrong', 500);
        }
    }

    public function update(UpdateCourseApiRequest $request, $id)
    {
        try {
            $course = Course::findOrFail($id);
            if(!$course)
            {
                return $this->apiResponse(null, 'course not exist', 203);
            }
            $course->update($request->all());

            return $this->apiResponse($course, 'course updated successfully', 200);
        } catch (\Exception $e) {
            return $this->apiResponse(null, 'something went wrong', 500);
        }
    }

    public function delete($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();
            return $this->apiResponse(null, 'course deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->apiResponse(null, 'something went wrong', 500);
        }
    }

//    public function enrolled_students($course_id)
//    {
//        $course = Course::with('students')->findOrFail($course_id);
//
//        if ($course->teacher_id !== auth()->user()->id) {
//            abort(403, 'You do not have access to this course.');
//        }
//
//        return view('frontend.teacher.courses.students',compact('course'));
//
//    }

}
