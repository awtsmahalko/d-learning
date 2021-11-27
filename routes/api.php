<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('class', App\Http\Controllers\ClassController::class);

Route::get('/video', [App\Http\Controllers\MeetingController::class, 'index']);
Route::get('/video/api', [App\Http\Controllers\MeetingController::class, 'api']);
Route::post('/video/create', [App\Http\Controllers\MeetingController::class, 'create']);
Route::get('/video/{id}', [App\Http\Controllers\MeetingController::class, 'show']);
Route::post('/video/{id}/edit', [App\Http\Controllers\MeetingController::class, 'updateStatus']);
Route::get('/video/attendee/{id}', [App\Http\Controllers\MeetingController::class, 'attendee']);
Route::post('/video/join', [App\Http\Controllers\MeetingController::class, 'join']);
Route::delete('/video/{id}', [App\Http\Controllers\MeetingController::class, 'destroy']);

// discussion :: post
Route::get('/post', [App\Http\Controllers\PostController::class, 'index']);
Route::post('/post', [App\Http\Controllers\PostController::class, 'store']);
Route::post('/post/comment/add', [App\Http\Controllers\PostController::class, 'commentStore']);
Route::get('/post/comment', [App\Http\Controllers\PostController::class, 'commentData']);
Route::post('/uploadPostAttachment', [App\Http\Controllers\PostController::class, 'uploadAtachment']);
Route::delete('/deletePostAttachment', [App\Http\Controllers\PostController::class, 'deletePostAttachment']);

// class list
Route::get('/studentsList', [App\Http\Controllers\ClassListController::class, 'studentsList']);
Route::get('/studentsList/students', [App\Http\Controllers\ClassListController::class, 'students']);
Route::post('/studentsList', [App\Http\Controllers\ClassListController::class, 'addStudent']);
Route::delete('/deleteStudentsList/{id}', [App\Http\Controllers\ClassListController::class, 'deleteStudentsList']);

// activity
Route::get('/class/activity/view', [App\Http\Controllers\ClassController::class, 'indexActivity']);
Route::get('/class/activity/detail', [App\Http\Controllers\ClassController::class, 'activityDetail']);
Route::post('/class/activity/add', [App\Http\Controllers\ClassController::class, 'createActivity']);

// activity :: studentwork
Route::post('/class/activity/uploadStudentWork', [App\Http\Controllers\ClassController::class, 'uploadStudentWork']);
Route::post('/class/activity/submitStudentWork', [App\Http\Controllers\ClassController::class, 'submitStudentWork']);
Route::get('/class/activity/studentworkdata', [App\Http\Controllers\ClassController::class, 'studentworkdata']);
Route::post('/class/activity/unsubmitStudentWork', [App\Http\Controllers\ClassController::class, 'unsubmitStudentWork']);
Route::get('/class/activity/studentswork', [App\Http\Controllers\ClassController::class, 'indexStudentWork']);
Route::post('/class/activity/addScore', [App\Http\Controllers\ClassController::class, 'addScore']);
Route::get('/class/activity/getScore', [App\Http\Controllers\ClassController::class, 'getScore']);

//atendance
Route::get('/attendance/view/record', [App\Http\Controllers\ClassController::class, 'attendance']);
Route::get('/attendance/modal/students', [App\Http\Controllers\ClassController::class, 'attendanceModalStudents']);
Route::post('/attendance/add/record', [App\Http\Controllers\ClassController::class, 'attendanceAddRecord']);

//leaderboard
Route::get('/leaderboard/student/work', [App\Http\Controllers\ClassController::class, 'studentWork']);
Route::get('/leaderboard/teacher/work', [App\Http\Controllers\ClassController::class, 'teacherWork']);

// activity :: classwork
Route::post('/class/activity/uploadClassworkAttachment', [App\Http\Controllers\ClassController::class, 'uploadClassworkAttachment']);
Route::delete('/class/activity/revertClassWorkMaterial', [App\Http\Controllers\ClassController::class, 'revertClassWorkMaterial']);
Route::delete('/class/activity/deleteClassWorkMaterial', [App\Http\Controllers\ClassController::class, 'deleteClassWorkMaterial']);
Route::get('/class/activity/downloadClassWorkMaterial', [App\Http\Controllers\ClassController::class, 'downloadClassWorkMaterial']);


// profile
Route::post('/updateProfile', [App\Http\Controllers\RegisterController::class, 'updateProfile']);
Route::post('/updatePassword', [App\Http\Controllers\RegisterController::class, 'updatePassword']);
