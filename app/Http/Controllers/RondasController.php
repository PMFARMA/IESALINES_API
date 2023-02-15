<?php

namespace App\Http\Controllers;
use App\Models\AuxTipoJuradoSubCat;
use App\Models\TipoJurado;
use App\Models\Subcategorias;
use App\Models\Edicion;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class RondasController extends Controller
{
    public function juradoPorcentaje(){

    }

    public function subCategoriaPorcentaje(){

    }

    public function activacionRonda(Request $request){
       
        $idEdicion = TipoJurado::where('id_edicion',$request->id_edicion)->update(['aceptacion_ronda'=>$request->aceptacion_ronda]);
        return $idEdicion;

        
    }
}
