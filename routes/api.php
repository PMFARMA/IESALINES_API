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


Route::prefix('/admin')->group(function(){
    
    Route::post('/email-login', [MailController::class, 'mailToLogin']);

    Route::post('/email-invitacion', [MailController::class, 'mailToinvitacion']);
    
    Route::post('/email-iniciacion', [MailController::class, 'mailToIniciacion']);
    
    Route::post('/email-recordatorio', [MailController::class, 'mailToRecordatorio']);

    Route::get('/edicion',[EdicionController::class,'index']);
    
    Route::get('/jurados',[JuradoController::class,'index']);
    
    Route::post('/jurados',[JuradoController::class,'create']);
    
    Route::delete('/jurados/{id}',[JuradoController::class,'destroy']);
    
    Route::put('/jurados/{id}',[JuradoController::class,'update']);
    
    Route::post('/jurados/id',[JuradoController::class,'getUserbyId']);
    
    Route::post('/jurados/email',[JuradoController::class,'getUserByEmail']);
    
    Route::put('jurados/aceptacion/{user}',[JuradoController::class,'userConfirmation'])->name('aceptacion')->middleware('signed');
    
    Route::get('/jurados/tipos', [TipoJuradoController::class, 'index']);
   
    Route::put('/aux-subcategorias', [CategoriasController::class, 'relateSubCatTipoJurado']);
    
    Route::get('/aux-subcategorias/{id}', [CategoriasController::class, 'getAuxTipoJuradoSubCat']);
    
    Route::get('/jurados/descarga-csv',[CSVController::class,'download']);
    
    Route::put('/config/popups',[PopUpController::class,'upsert']);
    
    Route::put('/config/limit-votacion',[TipoJuradoController::class,'updateLimitDate']);
    
    Route::get('/ronda/jurados-porcentajes',[RondasController::class,'juradoPorcentaje']);
    
    Route::get('/subcategorias',[CategoriasController::class,'getSubCategorias']);
    
    Route::get('/ronda/subcat-porcentajes',[RondasController::class,'subCategoriaPorcentaje']);
    
    Route::put('/ronda/switch', [RondasController::class, 'activacionRonda']);
    
    Route::delete('/ronda/subcat-votaciones/{id}', [VotacionesController::class, 'destroySubcatVotaciones']);
   
    Route::delete('/ronda/jurado-votaciones/{id}', [VotacionesController::class, 'destroyJuradoVotaciones']);
   
    Route::get('/ronda/subcat-result', [VotacionesController::class, 'getResultSubcat']);
    
    Route::get('/ronda/jurados-result/{id}',[VotacionesController::class, 'getResultSpecificSubcatJurados']);
    
    Route::get('/ronda/subcat-result/{id}',[VotacionesController::class, 'getResultSpecificSubcat']);
    
    Route::put('/ronda/premio', [VotacionesController::class, 'setReward']);
    
});    

Route::prefix('/jurado')->group(function(){
    
    Route::put('/votos',[VotacionesController::class, 'addVoto']);
    
    Route::get('/categorias/{id}',[CategoriasController::class,'getAllCategories']);
    
    Route::post('/popup',[PopUpController::class,'index']);

});    

// Route::get('/login/{id}', [LoginController::class, 'login'])->name('login')->middleware('signed');
Route::get('/login/{id}', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->post('/logout', [LoginController::class, 'logout']);

Route::middleware('auth:')->get('/prueba',function(){return $request->user();});


