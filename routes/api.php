<?php

use App\Http\Controllers\EdicionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

//Auth
Route::post('/login', [LoginController::class, 'login'])->middleware('web');
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/edicion',[EdicionController::class,'index']);