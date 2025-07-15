<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refreshToken']);
    });
});

Route::group(['middleware'=>'auth:sanctum','prefix' => 'courses'],function (){
    //Courses
    Route::get('/index', [CourseController::class, 'index']);
    Route::get('/show/{id}', [CourseController::class, 'show']);
    Route::post('/store', [CourseController::class, 'store']);
    Route::patch('/update/{id}', [CourseController::class, 'update']);
    Route::delete('/delete/{id}', [CourseController::class, 'delete']);
});
