<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

if ("PROD" == "LOCAL") {
	$_REQUEST['public'] = asset("public/material");
	$_REQUEST['mixAppBlade'] = asset('public/js/app.js');
	$_REQUEST['baseUrl'] = "/dlearning";
	$_REQUEST['imgUrl'] = "/public/storage";
} else {
	$_REQUEST['public'] = asset("material");
	$_REQUEST['mixAppBlade'] = mix('js/app.js');
	$_REQUEST['baseUrl'] = "";
	$_REQUEST['imgUrl'] = "storage";
}

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register');
Route::get('web', function () {
	return view('web');
});
Route::group(['middleware' => 'auth'], function () {
	Route::get('{any}', function () {
		if (Auth::check()) {
			return view('app');
		}
		return view('login');
	})->where('any', '.*');
});
