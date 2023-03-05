<?php

namespace App\Http\Controllers;
use App\Models\AuxTipoJuradoSubCat;
use App\Models\TipoJurado;
use App\Models\Subcategorias;
use App\Models\Edicion;
use App\Models\Votaciones;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RondasController extends Controller
{
    public function juradoPorcentaje(){
        $creatividad_count=0;
        $formacion_count=0;
        $salud_count=0;
        $array_final = [];
        $anio = Carbon::now()->year;
        $id_edicion = Edicion::select('id')->where('anio', $anio-1)->get();

        if(count($id_edicion)==0){
            return response()->json(["message"=>'no hay edición creada para este año'],404);
        }
        $jurados = User::select('as_jurado.*', 'as_tipojurado.nombre AS categoria')->where('as_jurado.id_edicion','=',$id_edicion)->join('as_tipojurado','as_jurado.id_tipojurado','=','as_tipojurado.id')->get();

        $total_sub_categorias = AuxTipoJuradoSubCat::select('*')->get();
        foreach ($total_sub_categorias as $index_subcategoria) {
            switch ($index_subcategoria->id_tipojurado) {
                case 1:
                    $creatividad_count = $creatividad_count +1;
                    break;

                case 2:
                    $formacion_count = $formacion_count + 1;
                    break;

                case 3:
                    $salud_count = $salud_count+1;
                    break;
            }

        }

        foreach ($jurados as $jurado) {
            // dd($jurado);
            $total_votacion = Votaciones::select('*')->where('id_jurado','=',$jurado->id)->count();
            // dd($jurado->categoria);
            switch ($jurado->categoria) {
                case 'creatividad':
                    if ($creatividad_count == 0){
                        return "No hay categorias de creatividad";
                    }
                    $porcentaje = ($total_votacion/$creatividad_count)*100;
                    array_push($array_final,$jurado,$porcentaje);
                    break;
                case 'formacion':
                    if ($formacion_count == 0){
                        return "No hay categorias de formacion";
                    }
                    $porcentaje = ($total_votacion/$formacion_count)*100;
                    array_push($array_final,$jurado,$porcentaje);
                    break;
                case 'salud':
                    if ($salud_count == 0){
                        return "No hay categorias de salud";
                    }
                    $porcentaje = ($total_votacion/$salud_count)*100;
                    array_push($array_final,$jurado,$porcentaje);
                    break;
            }
        }
        $total = 0;
        return response()->json([$array_final, $total]);

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
                array_push($arrayFinal,["calculo"=>$result[0]["count(*)"]/$value*100,"area"=>$info[0]->id_area,"codigo"=>$info[0]->codigo,"descripcion"=>$info[0]->descrip,"id_subcategoria"=>$info[0]->id]);
            }

        };

        return $arrayFinal;
    }

    public function activacionRonda(Request $request){

        $idEdicion = TipoJurado::where('id_edicion',$request->id_edicion)->update(['aceptacion_ronda'=>$request->aceptacion_ronda]);
        return $idEdicion;


    }

}

["key"=>"valor"];
