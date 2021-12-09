<?php

use App\Models\ClassActivityDetail;
use App\Models\Classes;
use App\Models\PostAttachments;
use App\Models\PostCommentAttachment;
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

Route::post('/class/add/record', [App\Http\Controllers\ClassController::class, 'addRecord']);
Route::get('/class/view/record', [App\Http\Controllers\ClassController::class, 'viewRecord']);
Route::post('/class/update/record', [App\Http\Controllers\ClassController::class, 'updateRecord']);
Route::delete('/class/delete/record', [App\Http\Controllers\ClassController::class, 'deleteRecord']);
Route::get('/class/user/category', [App\Http\Controllers\ClassController::class, 'fetchUserByCategory']);

Route::get('/video', [App\Http\Controllers\MeetingController::class, 'index']);
Route::get('/video/api', [App\Http\Controllers\MeetingController::class, 'api']);
Route::post('/video/create', [App\Http\Controllers\MeetingController::class, 'create']);
Route::get('/video/{id}', [App\Http\Controllers\MeetingController::class, 'show']);
Route::post('/video/{id}/edit', [App\Http\Controllers\MeetingController::class, 'updateStatus']);
Route::get('/video/attendee/{id}', [App\Http\Controllers\MeetingController::class, 'attendee']);
Route::post('/video/join', [App\Http\Controllers\MeetingController::class, 'join']);
Route::delete('/video/{id}', [App\Http\Controllers\MeetingController::class, 'destroy']);
Route::get('/video/tokens/credentials', [App\Http\Controllers\MeetingController::class, 'apiCredentials']);

// discussion :: post
Route::get('/post', [App\Http\Controllers\PostController::class, 'index']);
Route::post('/post', [App\Http\Controllers\PostController::class, 'store']);
Route::post('/post/comment/add', [App\Http\Controllers\PostController::class, 'commentStore']);
Route::get('/post/comment', [App\Http\Controllers\PostController::class, 'commentData']);
Route::post('/post/comment/uploadCommentAttachment', [App\Http\Controllers\PostController::class, 'uploadCommentAttachment']);
Route::post('/uploadPostAttachment', [App\Http\Controllers\PostController::class, 'uploadAtachment']);
Route::delete('/deletePostAttachment', [App\Http\Controllers\PostController::class, 'deletePostAttachment']);
Route::delete('/post/deleteAttachment', [App\Http\Controllers\PostController::class, 'deleteAttachment']);
Route::post('/post/delete', [App\Http\Controllers\PostController::class, 'deletePost']);
Route::delete('/post/comment/revertCommentAttachment', [App\Http\Controllers\PostController::class, 'revertCommentAttachment']);
Route::delete('/post/comment/deleteCommentAttachment', [App\Http\Controllers\PostController::class, 'deleteCommentAttachment']);


// class list
Route::get('/studentsList', [App\Http\Controllers\ClassListController::class, 'studentsList']);
Route::get('/studentsList/students', [App\Http\Controllers\ClassListController::class, 'students']);
Route::post('/studentsList', [App\Http\Controllers\ClassListController::class, 'addStudent']);
Route::delete('/deleteStudentsList/{id}', [App\Http\Controllers\ClassListController::class, 'deleteStudentsList']);

// activity
Route::get('/class/activity/dashboard', [App\Http\Controllers\ClassController::class, 'dashboardActivity']);
Route::get('/class/activity/view', [App\Http\Controllers\ClassController::class, 'indexActivity']);
Route::get('/class/activity/detail', [App\Http\Controllers\ClassController::class, 'activityDetail']);
Route::post('/class/activity/add', [App\Http\Controllers\ClassController::class, 'createActivity']);
Route::post('/class/activity/edit', [App\Http\Controllers\ClassController::class, 'updateActivity']);
Route::post('/class/activity/delete', [App\Http\Controllers\ClassController::class, 'deleteActivity']);


// activity :: studentwork
Route::post('/class/activity/uploadStudentWork', [App\Http\Controllers\ClassController::class, 'uploadStudentWork']);
Route::post('/class/activity/submitStudentWork', [App\Http\Controllers\ClassController::class, 'submitStudentWork']);
Route::get('/class/activity/studentworkdata', [App\Http\Controllers\ClassController::class, 'studentworkdata']);
Route::post('/class/activity/unsubmitStudentWork', [App\Http\Controllers\ClassController::class, 'unsubmitStudentWork']);
Route::get('/class/activity/studentswork', [App\Http\Controllers\ClassController::class, 'indexStudentWork']);
Route::post('/class/activity/addScore', [App\Http\Controllers\ClassController::class, 'addScore']);
Route::get('/class/activity/getScore', [App\Http\Controllers\ClassController::class, 'getScore']);
Route::delete('/class/activity/deleteStudentWork', [App\Http\Controllers\ClassController::class, 'deleteStudentWork']);

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
Route::get('/class/activity/downloadClassWorkMaterial/{class_id}/{material_id}', [App\Http\Controllers\ClassController::class, 'downloadClassWorkMaterial']);

// downloadPage
Route::get('/class/activity/downloadStudentWork/{class_id}/{id}', function ($class_id, $id) {
    $material = ClassActivityDetail::where('id', $id)->first();
    $class = Classes::find($class_id);

    $file = public_path() . '/storage/classactivity/' .  $class->code . '/' . $material->class_activity_id . '/' . $material->filename;

    $headers = [
        'Content-Type' => 'application/' . $material->filetype,
    ];

    return response()->download($file, $material->filename, $headers);
});

Route::get('/class/post/downloadAttachment/{class_code}/{id}', function ($class_code, $id) {
    $attachment = PostAttachments::where('id', $id)->first();

    $file = public_path() . '/storage/postattachment/' .  $class_code . '/' . $attachment->filename;

    $headers = [
        'Content-Type' => 'application/' . $attachment->filetype,
    ];

    return response()->download($file, $attachment->filename, $headers);
});

Route::get('/post/comment/downloadCommentAttachment/{class_code}/{id}', function ($class_code, $id) {
    $attachment = PostCommentAttachment::where('id', $id)->first();

    $file = public_path() . '/storage/postcommentattachment/' .  $class_code . '/' . $attachment->post_comment_id . '/' . $attachment->filename;

    $headers = [
        'Content-Type' => 'application/' . $attachment->filetype,
    ];

    return response()->download($file, $attachment->filename, $headers);
});



// profile
Route::post('/updateProfile', [App\Http\Controllers\RegisterController::class, 'updateProfile']);
Route::post('/updatePassword', [App\Http\Controllers\RegisterController::class, 'updatePassword']);
Route::post('/updateAvatar', [App\Http\Controllers\RegisterController::class, 'updateAvatar']);

Route::delete('/user/delete/record', [App\Http\Controllers\RegisterController::class, 'deleteUser']);

// student
Route::post('/student/add/record', [App\Http\Controllers\RegisterController::class, 'createStudent']);
Route::get('/student/view/record', [App\Http\Controllers\RegisterController::class, 'viewStudent']);
Route::post('/student/update/record', [App\Http\Controllers\RegisterController::class, 'updateStudent']);

// teacher
Route::post('/teacher/add/record', [App\Http\Controllers\RegisterController::class, 'createTeacher']);
Route::get('/teacher/view/record', [App\Http\Controllers\RegisterController::class, 'viewTeacher']);
Route::post('/teacher/update/record', [App\Http\Controllers\RegisterController::class, 'updateTeacher']);
