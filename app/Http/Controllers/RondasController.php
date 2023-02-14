<?php

namespace App\Http\Controllers;
use App\Models\AuxTipoJuradoSubCat;
use App\Models\Subcategorias;
use App\Models\Edicion;
use App\Models\Votaciones;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class RondasController extends Controller
{
    public function juradoPorcentaje(){

    }

    public function subCategoriaPorcentaje(){

        $cantidadJuradosSub = [];
        $arrayFinal = [];

        $anio = Carbon::now()->year;
        $id_edicion = Edicion::select('id')->where('anio', $anio-1)->get();

      
        if(count($id_edicion)==0){
            return response()->json(["message"=>'no hay edición creada para este año'],404);
        }

        // return $id_edicion;
        $results = AuxTipoJuradoSubCat::select('*')->where('id_edicion',$id_edicion[0]->id)->get();

        // return $results
        foreach($results as $result){
            $totalJurados = User::selectRaw('count(*)')->where('id_tipojurado',$result->id_tipojurado)->where('id_edicion',$id_edicion[0]->id)->get();
            array_push($cantidadJuradosSub,[$result->id_subcategoria=>$totalJurados[0]["count(*)"]]);
        };

        // return $cantidadJuradosSub;
        foreach($cantidadJuradosSub as $data){

            foreach($data as $key => $value){
                $result = Votaciones::selectRaw('count(*)')->where('id_cod_particip',$key)->get();
                $info = Subcategorias::select('*')->where('id',$key)->get();
                array_push($arrayFinal,["calculo"=>$result[0]["count(*)"]/$value*100,"area"=>$info[0]->id_area,"codigo"=>$info[0]->codigo,"descripcion"=>$info[0]->descrip]);
            }
            
        };

        return $arrayFinal;
    }
}

["key"=>"valor"];
