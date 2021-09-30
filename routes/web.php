<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
	if (Auth::check()) {
		return view('welcome');
	}
	return view('login');
});

Route::get('/login', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register');

Route::group(['middleware' => 'auth'], function () {

	Route::get('/', function () {
		return view('dashboard');
	})->name('home');

	Route::get('home', function () {
		return view('dashboard');
	})->name('home');

	Route::resource('class', 'App\Http\Controllers\ClassController', ['except' => ['show']]);

	Route::get('/classes-vue', function () {
		return view('classes.vue');
	})->name('class.vue');
	Route::get('/classes-vue-1', function () {
		return view('classes.vue1');
	})->name('class.vue1');
});
