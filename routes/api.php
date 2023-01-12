<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

//Auth
Route::post('/login', [LoginController::class, 'login'])->middleware('web');
Route::post('/logout', [LoginController::class, 'logout']);
