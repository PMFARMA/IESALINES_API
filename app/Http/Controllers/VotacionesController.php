<?php

namespace App\Http\Controllers;

use App\Models\Subcategorias;
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
    public function getResultSubcat(Request $request)
    {
        // $o =0;
        // $od = 0;
        // $d = 0;
        // $dd = 0;
        // $voto1 = 0;
        $array_subcategorias = [];
        $empate = 0;
        $res3 = Subcategorias::from('as_edicion_cods_particip AS subcategorias')->select("subcategorias.descrip",'subcategorias.id_area','subcategorias.codigo', 'subcategorias.id')->where('subcategorias.id_edicion',28)->get();

        $user_votando = Subcategorias::from('as_edicion_obras AS obras')->select("obras.id", 'obras.descripcion', 'obras.id_cod_particip')->join('as_edicion_cods_particip AS votos','votos.id','=','obras.id_cod_particip')->where('votos.id_edicion',28)->get();

        foreach ($res3 as $subcategoria) {
            $infoCategoria = $this->getResultSpecificSubcat($request, $subcategoria->id,1);
            // return $infoCategoria['informacion'];
            foreach ($$infoCategoria['informacion'] as $informacion) {
                if(!$informacion1){
                    $informacion1 = $informacion;
                    array_pus($array_subcategorias,);
                }else{

                }
                if ($informacion == $informacion1) {
                    $empate = 1;
                    return 'empate';
            }
        }
        // return $user_votando;
    //     foreach ($user_votando as $id_votar) {
    //         return $id_votar;
    //         $votos_totales = [];
    //         foreach ($res3 as $key) {
    //             if ($id_votar['id_cod_particip'] ==$key['id']){
    //                 // return $key;
    //                 switch ($key['voto']) {
    //                     case 'o':
    //                         $o++;
    //                         break;
    //                     case 'od':
    //                         $od++;
    //                         break;
    //                     case 'd':
    //                         $d++;
    //                         break;
    //                     case 'dd':
    //                         $dd++;
    //                         break;
    //                 }
    //             }
    //         }
    //         $votos_totales = array(
    //             "oro" => $o,
    //             "oro_desierto"=>$od,
    //             "aspid" => $d,
    //             "desierto_aspid" => $dd,
    //             "descripcion" => $id_votar['descrip']
    //         );
    //         $count = 0;
    //         arsort($votos_totales);
    //         // if ($votos_totales[0] == $votos_totales[1]) {
    //         //     $votos_totales[0] = 'Empate';
    //         // }
    //         // return $votos_totales;
    //         foreach ($votos_totales as $voto) {
    //             // return var_dump(getType($voto));
    //             if (!$voto1 && getType($voto) != 'string') {
    //                 $voto1 = $voto;
    //                 // return $voto1;
    //             }else{
    //                 if ($voto1 == $voto) {
    //                     # code...
    //                 }else{

    //                 }
    //             }
    //         }
    //         array_push($array_subcategorias,$votos_totales);
    //     }
    //     return $array_subcategorias;

    //          $array_votaciones = [];
    //    for($i = 0;$i<count($res3);$i++){

    //         // if($array_votaciones[$res3[$i]->id ])
    //         array_push($array_votaciones,[$res3[$i]->id ,$res3[$i]->voto], );

    //    }


    //    for($i=0;$i<count($array_votaciones);$i++){
    //     for($j=0;$j<count($array_votaciones);$j++){
    //         if($array_votaciones[$i][0]==$array_votaciones[$j][0]){

    //         }
    //     }
    //    };

// return $array_votaciones;
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

        $obras = EdicionObras::select('id','titulo','id_cod_particip')->where('id_cod_particip', $id)->get();

        $votosDesierto = Votaciones::selectRaw('count(*) as desierto')->where('id_cod_particip', $id)->whereIn('voto',array('dd',$premioDesierto))->get();


        // return $votosDesierto;
        $arraydeVotaciones = [];
        foreach ($obras as $obra){
            $votaciones = Votaciones::selectRaw('voto')->where('id_obra', $obra->id)->whereIn('voto',array('d',$premio))->distinct()->get();
            $total = Votaciones::selectRaw('count(*) as total')->where('id_obra', $obra->id)->get();

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
}
