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
        $idEdicion = TipoJurado::find($request->id_edicion)
        
        if($idEdicion){
            $idEdicion->aceptacion_ronda = $request->acceptacion_ronda;
            $idEdicion->save();
        }
        return request()->json(["message"=>"cambios realizados en la columna aceptacion_ronda"],201);
    }
}
