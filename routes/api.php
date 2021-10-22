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
Route::post('/video/create', [App\Http\Controllers\MeetingController::class, 'create']);


Route::get('/post', [App\Http\Controllers\PostController::class, 'index']);
Route::post('/post', [App\Http\Controllers\PostController::class, 'store']);
Route::post('/post/comment/add', [App\Http\Controllers\PostController::class, 'commentStore']);
Route::get('/post/comment', [App\Http\Controllers\PostController::class, 'commentData']);

Route::post('/uploadPostAttachment', [App\Http\Controllers\PostController::class, 'uploadAtachment']);
Route::delete('/deletePostAttachment', [App\Http\Controllers\PostController::class, 'deletePostAttachment']);

// class list
Route::get('/studentsList', [App\Http\Controllers\ClassListController::class, 'studentsList']);
Route::post('/studentsList', [App\Http\Controllers\ClassListController::class, 'addStudent']);
