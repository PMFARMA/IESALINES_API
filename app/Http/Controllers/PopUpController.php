<?php

namespace App\Http\Controllers;

use App\Models\PopUp;
use Illuminate\Http\Request;

class PopUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $popUp = PopUp::select('*')->where('tipo',$request->tipo)->where('id_edicion',$request->id_edicion)->get();
        
        return $popUp;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       
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
     * @param  \App\Models\PopUp  $popUp
     * @return \Illuminate\Http\Response
     */
    public function show(PopUp $popUp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PopUp  $popUp
     * @return \Illuminate\Http\Response
     */
    public function edit(PopUp $popUp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PopUp  $popUp
     * @return \Illuminate\Http\Response
     */
    public function upsert(Request $request)
    {

        // return gettype($request->id_tipojurado);
        PopUp::updateOrCreate(
            ["tipo"=>$request->tipo,
            "id_tipo_jurado"=>$request->id_tipojurado,
            "id_edicion"=>$request->id_edicion],
            [
            "tipo"=>$request->tipo,
            "titulo"=>$request->titulo,
            "subtitulo"=>$request->subtitulo,
            "mensaje"=>$request->mensaje,
            "fecha_reunion"=>$request->fecha_reunion,
            "ruta_video"=>$request->ruta_video,
            "id_tipo_jurado"=>$request->id_tipojurado,
            "id_edicion"=>$request->id_edicion
        ])->where('tipo',$request->tipo);

        return response()->json(["message"=>"PopUp registrado"],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PopUp  $popUp
     * @return \Illuminate\Http\Response
     */
    public function destroy(PopUp $popUp)
    {
        //
    }
}
