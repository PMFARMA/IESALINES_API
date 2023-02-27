<?php

namespace App\Http\Controllers;

use App\Models\Votaciones;
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

    public function  getResultSpecificSubcat(Request $request, $id){
        $arrTest=[];
        // $results = Votaciones::from('as_edicion_obras_voto_jurado as votaciones')->select('id_obra', 'voto')->where('id_cod_particip', $id)->whereIn('votaciones.voto', array('d','dd','o','od'))->get();
        // return $results;
        
        // $w = EdicionObras::from('as_edicion_obras as obras')->selectRaw('obras.id,obras.titulo,count(*)')->join('as_edicion_obras_voto_jurado','as_edicion_obras_voto_jurado.id_obra','=','obras.id')->where('obras.id_cod_particip','=', $id)->get();
        $w = EdicionObras::select('id','titulo','id_cod_particip')->where('id_cod_particip', $id)->get();

        // return $w;
        // $w = DB::table('as_edicion_obras')->select('id',(DB::table('as_edicion_obras_voto_jurado')->select('count(*)')))->where('id_cod_particip',$id)
        // ->get();
        // return $w;
        $vd = Votaciones::selectRaw('count(*) as desierto')->where('id_cod_particip', $id)->whereIn('voto',array('dd','od'))->get();

       
        // return $vd;
        $arraydeVotaciones = [];
        foreach ($w as $z){
            $v = Votaciones::selectRaw('voto')->where('id_obra', $z->id)->distinct()->get();
            $total = Votaciones::selectRaw('count(*) as total')->where('id_obra', $z->id)->get();

            // return $w;
            count($v)>0 && $z->voto = $v[0]->voto;
            count($total)>0 && $z->total = $total[0]->total;
 
            array_push($arraydeVotaciones,$z);
            // array_push($arraydeVotaciones,[$z,$v,$total]);
        }

        // return $arraydeVotaciones;

        $sort = false;
        while (!$sort) {
            $sort = true;
            $i=0;
            $aux;
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
        $totalVotos=$vd[0]->desierto;
        
        foreach($arraydeVotaciones as $data){
            $totalVotos = $totalVotos+$data->total;
            // return $data->total;
        }
        
        $result = $totalVotos * $vd[0]->desierto /100;
        return $result;
        // return ["info"=>$arraydeVotaciones,"porcentaje"=>count($arraydeVotaciones)+];
        // return 'hola';
        // return $arrTest;
        // $results = [];
        // foreach($arraydeVotaciones as $voto){
        //     // return $voto;
        //     foreach($arrTest as $result ){
        //         return $result;
        //         // return [$result[1],$voto->id_cod_particip];
        //         if($result[2]==$voto->id_obra){
        //             array_push($results,[$result[0],$result[1],$voto->voto]);
        //         //     return 'hola';
        //         }
        //     }
        // }
        // return $results;
        // // $tVotos = Votaciones::selectRaw('count(*)')->where('id_obra', $results->id_obra)->where('id_cod_particip', $id)->get();
        // // array_push($arrTest,$tVotos);
                 
           
        
    }
}
