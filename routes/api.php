<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\CSVController;
use App\Http\Controllers\EdicionController;
use App\Http\Controllers\JuradoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\TipoJuradoController;
use App\Http\Controllers\PopUpController;
use App\Http\Controllers\RondasController;
use App\Http\Controllers\VotacionesController;


//Auth
Route::get('/login/{id}', [LoginController::class, 'login'])->name('login')->middleware('signed');
Route::post('/login-admin',[LoginController::class, 'loginAdmin']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::post('/email', [MailController::class, 'storemail'])->name('storemail');
Route::get('/edicion',[EdicionController::class,'index']);

Route::get('/jurado',[JuradoController::class,'index']);
Route::post('/jurado',[JuradoController::class,'create']);
Route::delete('/jurado/{id}',[JuradoController::class,'destroy']);
Route::put('/jurado/{id}',[JuradoController::class,'update']);

Route::post('/jurado/id',[JuradoController::class,'getUserbyId']);
Route::post('/jurado/email',[JuradoController::class,'getUserByEmail']);

Route::put('jurado/aceptacion/{user}',[JuradoController::class,'userConfirmation'])->name('aceptacion')->middleware('signed');
Route::get('/jurado/tipo', [TipoJuradoController::class, 'index']);
Route::put('/aux-subcategorias', [CategoriasController::class, 'relateSubCatTipoJurado']);


Route::get('/jurado/descarga-csv',[CSVController::class,'download']);

Route::put('/config/popup',[PopUpController::class,'upsert']);
Route::put('/config/limit-votacion',[TipoJuradoController::class,'updateLimitDate']);

Route::get('/ronda/jurado-porcentaje',[RondasController::class,'juradoPorcentaje']);

Route::get('/subcategorias',[CategoriasController::class,'getSubCategorias']);


Route::get('/ronda/subcat-porcentaje',[RondasController::class,'subCategoriaPorcentaje']);





Route::put('/ronda/switch', [RondasController::class, 'activacionRonda']);
Route::delete('/ronda/subcat-votaciones', [VotacionesController::class, 'destroySubcatVotaciones']);
Route::delete('/ronda/jurado-votaciones', [VotacionesController::class, 'destroyJuradoVotaciones']);


Route::get('/ronda/jurados-result/{id}',[VotacionesController::class, 'getResultSpecificSubcatJurados']);
Route::get('/ronda/subcat-result/{id}',[VotacionesController::class, 'getResultSpecificSubcat']);
