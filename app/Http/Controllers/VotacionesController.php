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
        
        $obras = EdicionObras::select('id','titulo','id_cod_particip')->where('id_cod_particip', $id)->get();

        $votosDesierto = Votaciones::selectRaw('count(*) as desierto')->where('id_cod_particip', $id)->whereIn('voto',array('dd','od'))->get();

       
        // return $votosDesierto;
        $arraydeVotaciones = [];
        foreach ($obras as $obra){
            $votaciones = Votaciones::selectRaw('voto')->where('id_obra', $obra->id)->distinct()->get();
            $total = Votaciones::selectRaw('count(*) as total')->where('id_obra', $obra->id)->get();

            // return $w;
            count($votaciones)>0 && $obra->voto = $votaciones[0]->voto;
            count($total)>0 && $obra->total = $total[0]->total;
 
            array_push($arraydeVotaciones,$obra);
            // array_push($arraydeVotaciones,[$obra,$v,$total]);
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
        
        return response()->json(["informacion"=>$arraydeVotaciones, "porcentaje-desierto"=>$result, "votos-desierto"=>$votosDesierto[0]->desierto]);
         
        
    }
}
