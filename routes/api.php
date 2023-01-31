<?php

use App\Http\Controllers\EdicionController;
use App\Http\Controllers\JuradoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JuradoController;
//Auth
Route::post('/login', [LoginController::class, 'login'])->middleware('web');
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/edicion',[EdicionController::class,'index']);
Route::delete('/jurado/delete/{id}',[JuradoController::class,'destroy']);
Route::get('/jurado',[JuradoController::class,'index']);

