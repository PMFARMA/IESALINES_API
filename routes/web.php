<?php

use App\Http\Controllers\AuthSocialController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
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
  return view('welcome');
})->name('welcome');

Route::get('auth/google', [AuthSocialController::class, 'redirectToGoogle']);
Route::get('auth/facebook', [AuthSocialController::class, 'redirectToFacebook']);
Route::get('auth/google/callback', [AuthSocialController::class, 'handleGoogleCallback']);
Route::get('auth/facebook/callback', [AuthSocialController::class, 'handleFacebookCallback']);
Route::get('auth/linkedin', [AuthSocialController::class, 'redirectToLinkedin']);
Route::get('auth/linkedin/callback', [AuthSocialController::class, 'handleLinkedinCallback']);
