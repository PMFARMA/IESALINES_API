<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuxTipoJuradoSubCat;
use App\Models\Subcategorias;
use App\Models\Categorias;
use App\Models\Edicion;
use App\Models\Obras;
use App\Models\Votaciones;
use Carbon\Carbon;


class CategoriasController extends Controller
{
    
    public function getSubCategorias(){

        $anio = Carbon::now()->year;
        $id_edicion = Edicion::select('id')->where('anio', $anio-1)->get();

      
        if(count($id_edicion)==0){
            return response()->json(["message"=>'no hay edición creada para este año'],404);
        }

        $subCategorias = Subcategorias::select('*')->where('id_edicion',$id_edicion[0]->id)->get();
        
        return $subCategorias;

    }


        
    public function relateSubCatTipoJurado(Request $request){

        $data = AuxTipoJuradoSubCat::select('id_subcategoria')->where('id_edicion',$request->id_edicion)->where('id_tipojurado',$request->id_tipojurado)->get();


        $repeat = [];
        foreach($data as $dat){

            if(!in_array($dat->id_subcategoria,$request->id_subcategoria)){
                
                AuxTipoJuradoSubCat::where('id_subcategoria',$dat->id_subcategoria)
                ->where('id_edicion',$request->id_edicion)
                ->where('id_tipojurado',$request->id_tipojurado)
                ->delete();
            }else{
                array_push($repeat,$dat->id_subcategoria); 
            }
        }

        if(count($repeat)!=count($request->id_subcategoria)){
            foreach($request->id_subcategoria as $data){
                if(!in_array($data,$repeat)){
                    AuxTipoJuradoSubCat::create([
                        'id_subcategoria'=>$data,
                        'id_tipojurado'=>$request->id_tipojurado,
                        'id_edicion'=>$request->id_edicion
                    ]);
                }
            }
   
        }
        
        return AuxTipoJuradoSubCat::find('*');
        
    }


    public function getAuxTipoJuradoSubCat($id){

        $data = AuxTipoJuradoSubCat::select('id_subcategoria')->where('id_tipojurado',$id)->get();
        $arrayIdSubcat = [];

        foreach($data as $id){
            array_push($arrayIdSubcat,$id->id_subcategoria);
        }
        
        return response()->json($arrayIdSubcat);
    }


    public function getAllCategories($id){

        $categorias = Categorias::select('*')->where('id_edicion',28)->get();

        foreach($categorias as $categoria){
            
            $contador = 0;
            $subcategorias = Subcategorias::select('*')->where('id_area',$categoria->id)->where('id_edicion',28)->get();

            foreach($subcategorias as $subcategoria){
                $obras = Obras::select('*')->where('id_cod_particip',$subcategoria->id)->get();
                $subcategoria->obras = $obras;
                $voto = Votaciones::select('*')->where('id_cod_particip',$subcategoria->id)->where('id_jurado',$id)->get();
                
                
                count($voto)>0?$subcategoria->votacion = true:$subcategoria->votacion = false;
                count($voto)>0 && $contador++;
            }
            
            $contador == count($subcategorias)? $categoria->votacion = true : $categoria->votacion = false;
            $categoria->subcategorias = $subcategorias;
        }
        return $categorias;
        // return $voto;
    }
    
}
