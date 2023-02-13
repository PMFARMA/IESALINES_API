<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuxTipoJuradoSubCat;
use App\Models\Subcategorias;
use App\Models\Edicion;
use Carbon\Carbon;


class CategoriasController extends Controller
{
    
    public function getSubCategorias(){

        $anio = Carbon::now()->year;
        $id_edicion = Edicion::select('id')->where('anio', $anio)->get();

        if(count($id_edicion)==0){
            return response()->json(["message"=>'no hay edición creada para este año'],404);
        }

        $subCategorias = Subcategorias::select('*')->where('id_edicion',$anio);
        
        return $subCategorias;

    }


    public function relateSubCat(){


    }
}
