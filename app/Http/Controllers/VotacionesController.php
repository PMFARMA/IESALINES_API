<?php

namespace App\Http\Controllers;

use App\Models\Subcategorias;
use App\Models\Votaciones;
use Illuminate\Http\Request;

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
        $res3 = Subcategorias::from('as_edicion_cods_particip AS subcategorias')->select("subcategorias.descrip",'votos.id_obra','votos.voto','subcategorias.id_area','subcategorias.codigo', 'subcategorias.id')->join('as_edicion_obras_voto_jurado AS votos','votos.id_cod_particip','=','subcategorias.id')->where('subcategorias.id_edicion',28)->whereIn('votos.voto',array('d','dd','o','od'))->get();
        // foreach ($res3 as $votoInfo) {
            //
            // var_dump($votoInfo );

            // return ;
            // switch ($voto->voto) {
            //     case 'o':
            //         # code...
            //         break;
            //     case 'od':
            //         # code...
            //         break;
            //     case 'd':
            //         # code...
            //         break;
            //     case 'dd':
            //         # code...
            //         break;
            // }
        // }

             $array_votaciones = [];
       for($i = 0;$i<count($res3);$i++){

            // if($array_votaciones[$res3[$i]->id ])
            array_push($array_votaciones,[$res3[$i]->id ,$res3[$i]->voto], );

       }


       for($i=0;$i<count($array_votaciones);$i++){
        for($j=0;$j<count($array_votaciones);$j++){
            if($array_votaciones[$i][0]==$array_votaciones[$j][0]){
                if
            }
        }
       };

return $array_votaciones;
    }

    public function getResultSpecificSubcatJurados($id){
        $res = Votaciones::from('as_edicion_obras_voto_jurado as votaciones')->select('as_edicion_obras.titulo','voto','as_jurado.nombre','as_jurado.empresa')->join('as_jurado','as_jurado.id','=','votaciones.id_jurado')->join('as_edicion_obras','as_edicion_obras.id','=','votaciones.id_obra')->where('votaciones.id_cod_particip',$id)->whereIn('votaciones.voto',array('d','dd','o','od'))->get();

        return $res;
    }






}
