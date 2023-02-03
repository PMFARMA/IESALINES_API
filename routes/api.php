<?php

use App\Http\Controllers\DownloadCsvController;
use App\Http\Controllers\EdicionController;
use App\Http\Controllers\JuradoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;

//Auth
Route::post('/login', [LoginController::class, 'login'])->middleware('web');
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/edicion',[EdicionController::class,'index']);
Route::get('/jurado',[JuradoController::class,'index']);
Route::get('/descarga-csv',[DownloadCsvController::class,'download']);
Route::post('/email', [MailController::class, 'storemail'])->name('storemail');
Route::post('/jurado/aceptacion/{id}',[JuradoController::class,'getUserbyId']);
Route::delete('/jurado/delete/{id}',[JuradoController::class,'destroy']);
Route::put('jurado/aceptacion/{user}',[JuradoController::class,'userConfirmation'])->name('aceptacion')->middleware('signed');
Route::put('/jurado/update/{id}',[JuradoController::class,'update']);
