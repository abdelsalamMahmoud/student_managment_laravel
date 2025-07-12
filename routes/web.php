<?php

use App\Http\Controllers\backend\CourseController;
use App\Http\Controllers\backend\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


//START ADMIN ROUTES
Route::group(['middleware' => ['is_admin']],function (){

    //dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Courses
    Route::get('/courses/index', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses/store', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/edit/{id}', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/update/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::get('/courses/delete/{id}', [CourseController::class, 'delete'])->name('courses.delete');

});



Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');
