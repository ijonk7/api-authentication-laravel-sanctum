<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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

/// arahkan ke route ini ketika user klik "login with google"
Route::get('login/google', [LoginController::class, 'google'])->middleware('guest');
/// arahkan ke route ini ketika user klik "register with google"
Route::get('register/google', [LoginController::class, 'google'])->middleware('guest');
/// arahkan ke route ini ketika user klik "login with facebook"
Route::get('login/facebook', [LoginController::class, 'facebook'])->middleware('guest');
/// arahkan ke route ini ketika user klik "register with facebook"
Route::get('register/facebook', [LoginController::class, 'facebook'])->middleware('guest');
/// route untuk menampung callback dari google
Route::get('auth/google/callback', [LoginController::class, 'google_callback']);
/// route untuk menampung callback dari facebook
Route::get('auth/facebook/callback', [LoginController::class, 'facebook_callback']);
