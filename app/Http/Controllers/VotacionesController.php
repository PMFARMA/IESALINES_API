<?php

namespace App\Http\Controllers;

use App\Models\Subcategorias;
use App\Models\Votaciones;
use App\Models\Obras;
use App\Models\EdicionObras;
use Illuminate\Http\Request;
use DB;

class VotacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Votaciones  $votaciones
     * @return \Illuminate\Http\Response
     */
    public function show(Votaciones $votaciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Votaciones  $votaciones
     * @return \Illuminate\Http\Response
     */
    public function edit(Votaciones $votaciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Votaciones  $votaciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Votaciones $votaciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Votaciones  $votaciones
     * @return \Illuminate\Http\Response
     */
    public function destroySubcatVotaciones(Request $request)
    {
        $res= Votaciones::where('id_cod_particip', $request->id_cod_particip)->delete();
        return $res;
    }
    public function destroyJuradoVotaciones(Request $request)
    {
        $res2= Votaciones::where('id_jurado', $request->id_jurado)->delete();
        return $res2;
    }
    public function getResultSubcat(Request $request)
    {

        $fase = 1;
        $array_subcategorias = [];
        $tipoEmpate = '';
        $informacionAux = false;
        $res3 = Subcategorias::from('as_edicion_cods_particip AS subcategorias')->select("subcategorias.descrip",'subcategorias.id_area','subcategorias.codigo', 'subcategorias.id', 'Subcategorias.tipo_premio')->where('subcategorias.id_edicion',28)->get();

        $user_votando = Subcategorias::from('as_edicion_obras AS obras')->select("obras.id", 'obras.descripcion', 'obras.id_cod_particip')->join('as_edicion_cods_particip AS votos','votos.id','=','obras.id_cod_particip')->where('votos.id_edicion',28)->get();

        foreach ($res3 as $subcategoria) {
            $infoCategoria = $this->getResultSpecificSubcat($request, $subcategoria->id,$fase);
            // return $infoCategoria['informacion'];
            $infoCategoria['id_subcategoria'] = $subcategoria->id;
            $infoCategoria['codigo'] = $subcategoria->id_area.$subcategoria->codigo;
            $infoCategoria['titulo'] = $subcategoria->descrip;
            if($infoCategoria['porcentaje-desierto'] >= 50){
                $infoCategoria['desierto'] = true;

                if($subcategoria->tipo_premio == 'diploma'){
                    $infoCategoria['tipo_desierto'] = 'd';
                }else{
                    if($fase == 1){
                        $infoCategoria['tipo_desierto'] = 'o';
                    }else{
                        $infoCategoria['tipo_desierto'] = 'p';
                    }
                }

            }else{
                $informacionAux = false;
                foreach ($infoCategoria['informacion'] as $informacion) {
                    if(!$informacionAux){
                        $informacionAux = $informacion->total;

                    }else{
                        if ($informacion->total == $informacionAux) {
                            $infoCategoria['empate']= True;
                            $infoCategoria['tipoEmpate'] = $informacion->voto;
                    }
                }
            }
        }

        array_push($array_subcategorias,$infoCategoria);
    }
    return $array_subcategorias;
}



    public function getResultSpecificSubcatJurados($id){
        $res = Votaciones::from('as_edicion_obras_voto_jurado as votaciones')
        ->select('as_edicion_obras.titulo','voto','as_jurado.nombre','as_jurado.empresa')
        ->join('as_jurado','as_jurado.id','=','votaciones.id_jurado')
        ->join('as_edicion_obras','as_edicion_obras.id','=','votaciones.id_obra')
        ->where('votaciones.id_cod_particip',$id)->whereIn('votaciones.voto',array('d','dd','o','od'))->get();

        return $res;
    }






    public function  getResultSpecificSubcat(Request $request, $id,$fase){

        if($fase == 1){
            $premioDesierto = 'od';
            $premio = 'o';
        }else{
            $premioDesierto = 'pd';
            $premio = 'p';
        }

        $obras = EdicionObras::select('id','titulo','id_cod_particip','premio')->where('id_cod_particip', $id)->get();

        $votosDesierto = Votaciones::selectRaw('count(*) as desierto')->where('id_cod_particip', $id)->whereIn('voto',array('dd',$premioDesierto))->get();


        // return $votosDesierto;
        $arraydeVotaciones = [];
        foreach ($obras as $obra){
            $votaciones = Votaciones::selectRaw('voto')->where('id_obra', $obra->id)->whereIn('voto',array('d',$premio))->distinct()->get();

            $total = Votaciones::selectRaw('count(*) as total')->where('id_obra', $obra->id)->whereIn('voto',array('d',$premio))->get();

            // return $w;

            count($votaciones)>0 && $obra->voto = $votaciones[0]->voto;
            count($total)>0 && $obra->total = $total[0]->total;

            if(!$obra->voto){
                $obra->total= 0;
            }



            array_push($arraydeVotaciones,$obra);
            // array_push($arraydeVotaciones,[$obra,$v,$total]);
        }

        // return $arraydeVotaciones;

        $sort = false;
        while (!$sort) {
            $sort = true;
            $i=0;
            $aux = 0;
            while($i<count($arraydeVotaciones)-1){
                if($arraydeVotaciones[$i]->total<$arraydeVotaciones[$i+1]->total){
                    $sort = false;
                    $aux = $arraydeVotaciones[$i];
                    $arraydeVotaciones[$i]=$arraydeVotaciones[$i+1];
                    $arraydeVotaciones[$i+1] = $aux;
                }
                $i++;
            }
        }

        $result = 0;
        $totalVotos=$votosDesierto[0]->desierto; // sumamos al total de votos el desierto para obtener el total de votos de la subcategoria.

        foreach($arraydeVotaciones as $data){
            $totalVotos = $totalVotos+$data->total;

        }

       if ($totalVotos > 0 && $votosDesierto[0]->desierto > 0) {
            $result = floor($votosDesierto[0]->desierto/$totalVotos * 100);


        }else if($totalVotos == 0 && $votosDesierto[0]->desierto>0){
            $result = 100;
        }else{
            $result = 0;
        }

        return ["informacion"=>$arraydeVotaciones, "porcentaje-desierto"=>$result, "votos-desierto"=>$votosDesierto[0]->desierto];


    }

    public function setReward(Request $request){
        
        $obra= Obras::find($request->id);
        
        if ($obra) {
            $obra->premio = $request->premio;
            $obra->save();
        } else {
            return response()->json(["message" => "Obra no encontrado en la base de datos"], 404);
        }
        return response()->json(["message" => "Premio actualizado"], 201);

    }
}

