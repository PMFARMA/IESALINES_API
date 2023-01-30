<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;

// //Auth
// Route::post('/login', [LoginController::class, 'login'])->middleware('web');
// Route::post('/logout', [LoginController::class, 'logout']);



//Mail --Laura
Route::get('/email', ('emails.form-email'))->name('form-email');
Route::post('/email', [MailController::class, 'storemail'])->name('email');