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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        PopUp::create([
            "tipo"=>$request->tipo,
            "titulo"=>$request->titulo,
            "subtitulo"=>$request->subtitulo,
            "mensaje"=>$request->mensaje,
            "fecha_reunion"=>$request->fecha_reunion,
            "ruta_video"=>$request->ruta_video,
            "id_tipo_jurado"=>$request->id_tipo_jurado,
            "id_edicion"=>$request->id_edicion
        ]);
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
    public function update(Request $request, PopUp $popUp)
    {
        //
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
