<?php

use App\Http\Controllers\backend\CourseController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\frontend\AssignmentController;
use App\Http\Controllers\frontend\GradeController;
use App\Http\Controllers\frontend\StudentController;
use App\Http\Controllers\frontend\TeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


//START ADMIN ROUTES
Route::group(['middleware' => ['is_admin']],function (){

    //dashboard
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    //Courses
    Route::get('/courses/index', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses/store', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/edit/{id}', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/update/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::get('/courses/delete/{id}', [CourseController::class, 'delete'])->name('courses.delete');

    //Users
    Route::get('/users/index', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
});

//START TEACHER ROUTES
Route::group(['prefix'=>'/teacher','middleware' => ['is_teacher']],function (){

    //dashboard
    Route::get('/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');

    //Courses
    Route::get('/courses/create', [CourseController::class, 'create'])->name('teacher.courses.create');
    Route::post('/courses/store', [CourseController::class, 'store'])->name('teacher.courses.store');
    Route::get('/courses/edit/{id}', [CourseController::class, 'edit'])->name('teacher.courses.edit');
    Route::put('/courses/update/{id}', [CourseController::class, 'update'])->name('teacher.courses.update');
    Route::get('/courses/delete/{id}', [CourseController::class, 'delete'])->name('teacher.courses.delete');

    Route::get('/course/students/{course_id}', [CourseController::class, 'enrolled_students'])->name('teacher.enrolled.students');

    //Grades
    Route::get('/create/{student_id}/grade/{course_id}', [GradeController::class, 'create'])->name('create.grade');
    Route::post('/store/{student_id}/grade/{course_id}', [GradeController::class, 'store'])->name('store.grade');

    //ASSIGNMENTS
    Route::get('/create/assignments/{course_id}', [AssignmentController::class, 'create'])->name('create.assignment');
    Route::post('/store/assignment/{course_id}', [AssignmentController::class, 'store'])->name('store.assignment');

});

//START TEACHER ROUTES
Route::group(['prefix'=>'student','middleware' => ['is_student']],function (){

    //dashboard
    Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');

    Route::get('/courses', [StudentController::class, 'get_enrolled_courses'])->name('student.courses');
    Route::get('/enroll/course/{course_id}', [StudentController::class, 'enroll_course'])->name('student.enroll.course');
    Route::get('/assignments/{course_id}', [StudentController::class, 'get_assignments'])->name('student.assignments');
});



Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');
