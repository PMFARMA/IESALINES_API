<?php

namespace App\Http\Controllers;

use App\Models\TipoJurado;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Edicion;
use Carbon\Carbon;

class TipoJuradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anio = Carbon::now()->year;
        $id_edicion = Edicion::select('id')->where('anio', $anio)->get();

        if(count($id_edicion)==0){
            return response()->json(["message"=>'no hay edición creada para este año'],404);
        }

        $data = TipoJurado::select("*")->where("id_edicion", $id_edicion[0]->id)->get();

        foreach($data as $object){
            $object->categoria = explode(",",$object->categoria);
        }
        return $data;
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
     * @param  \App\Models\TipoJurado  $tipoJurado
     * @return \Illuminate\Http\Response
     */
    public function show(TipoJurado $tipoJurado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoJurado  $tipoJurado
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoJurado $tipoJurado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoJurado  $tipoJurado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoJurado $tipoJurado)
    {
        //
    }
    public function updateLimitDate(Request $request, $ronda)
    {
        $tipoJurado = TipoJurado::find($request->id);

        if ($tipoJurado) {
            $tipoJurado->limit_Ronda_1 = $request->limit_date;
            $tipoJurado->save();
        } else {
            return response()->json(["message" => "Tipo de jurado no encontrado en la base de datos"], 404);
        }

    }
    // public function updateInitDate(Request $request, $ronda)
    // {
    //     $tipoJurado = TipoJurado::find($request->id);

    //     if ($tipoJurado) {
    //         $tipoJurado->limit_Ronda_1 = $request->nombre;
    //         $tipoJurado->save();
    //     } else {
    //         return response()->json(["message" => "Tipo de jurado no encontrado en la base de datos"], 404);
    //     }

    // }

    public function updateSubCategorias(Request $request)
    {
        $tipojurado = TipoJurado::find($request->id);

        if($tipojurado){
            $tipojurado->categoria = implode(",",$request->subcategoria);
            $tipojurado->save();
        }
        return request()->json(["message"=>"subcategorías agregadas"],201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoJurado  $tipoJurado
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoJurado $tipoJurado)
    {
        //
    }
}
