<?php

namespace App\Http\Controllers;
use App\Models\AuxTipoJuradoSubCat;
use App\Models\TipoJurado;
use App\Models\Subcategorias;
use App\Models\Edicion;
use App\Models\Votaciones;
use App\Models\Obras;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RondasController extends Controller
{
    public function juradoPorcentaje(){
       
        $id_edicion = Edicion::select('id')->where('estado', 0)->get();

        if(count($id_edicion)==0){
            return response()->json(["message"=>'no hay edición creada para este año'],404);
        }

        $jurados = User::select('nombre','id_tipojurado','empresa','id','obra_incompatible')->where('id_edicion',$id_edicion[0]->id)->where('admin',0)->get();

        $totalPorcientojurados = 0;
        foreach($jurados as $jurado){
           
           $votosIncompatibles = $this->calculoIncompatibles($jurado->obra_incompatible,$jurado->id_tipojurado);
           $totalVotos = AuxTipoJuradoSubCat::select('*')->where('id_tipojurado',$jurado->id_tipojurado)->count();
           $totalVotosRealizados = Votaciones::select('*')->where('id_jurado',$jurado->id)->count();
           
           $totalVotos = $totalVotos - $votosIncompatibles;
           $totalVotos <= 0 && $totalVotos = 1; 
           $tantoPorciento = $totalVotosRealizados/$totalVotos*100;
           $tantoPorciento >100 && $tantoPorciento = 0;
           $jurado->progreso = $tantoPorciento;
           $totalPorcientojurados = $totalPorcientojurados + $tantoPorciento;
        }
        $respuesta = [];
        $calculoTotal = ($totalPorcientojurados/(count($jurados)*100))*100;
        array_push($respuesta,["calculo_total"=>$calculoTotal],$jurados);

        return response()->json($respuesta);

    }

    private function calculoIncompatibles($obras,$id_tipojurado){

        
           $contadorObrasIncompatibles = 0;
           $obrasIncompatibles = explode(',',$obras);

           if($obrasIncompatibles[0]!=''){

                foreach($obrasIncompatibles as $obra){
                    $idCod = Obras::select('id_cod_particip')->where('id',$obra)->get();
                    
                    $idTip = AuxTipoJuradoSubCat::select('id_tipojurado')->where('id_subcategoria',$idCod[0]->id_cod_particip)->get();
                    
                    $idTip[0]->id_tipojurado == $id_tipojurado && $contadorObrasIncompatibles++;
                }
            }
           return $contadorObrasIncompatibles;
    }

    public function subCategoriaPorcentaje(){

        $cantidadJuradosSub = [];
        $arrayFinal = [];

        $id_edicion = Edicion::select('id')->where('estado', 0)->get();


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
                $value == 0 && $value = 1;
                $result = Votaciones::selectRaw('count(*)')->where('id_cod_particip',$key)->get();
                $info = Subcategorias::select('*')->where('id',$key)->get();
                array_push($arrayFinal,["calculo"=>$result[0]["count(*)"]/$value*100,"area"=>$info[0]->id_area,"codigo"=>$info[0]->codigo,"descripcion"=>$info[0]->descrip,"id_subcategoria"=>$info[0]->id]);
            }

        };

        return $arrayFinal;
    }

    public function activacionRonda(Request $request){

        $idEdicion = TipoJurado::where('id_edicion',$request->id_edicion)->update(['aceptacion_ronda'=>$request->aceptacion_ronda]);
        return $request->aceptacion_ronda;


    }

}

