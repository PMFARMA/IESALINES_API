<?php

namespace App\Http\Controllers;
use App\Models\AuxTipoJuradoSubCat;
use App\Models\Subcategorias;
use App\Models\Edicion;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class RondasController extends Controller
{
    public function juradoPorcentaje(){
        $jurado = User::select('*')->where('id_edicion','=','25')->join('as_tipojurado','as_jurado.id_tipojurado','as_tipojurado.id')->get();
        dd($jurado);
    
    }

    public function subCategoriaPorcentaje(){

    }
}
