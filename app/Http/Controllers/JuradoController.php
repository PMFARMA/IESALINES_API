<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Edicion;
use Carbon\Carbon;
use Illuminate\Http\Request;


class JuradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anio = Carbon::now()->year;
        $id_edicion = Edicion::select('id')->where('anio', $anio-4)->get();
        $item = User::select('id', 'Nombre', 'Empresa', 'Tipo_jurado','Email','nom_imagen','id_tipojurado')->where('id_edicion', $id_edicion[0]->id)->get();

        $users = User::join('tipojurado', 'as_jurado.id', '=', 'tipojurado.id')->get(['as_users.id', 'users.nombre', 'tipo_jurado.nombre']);




        return  $item;

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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user){
            $user->update($request->all());

        }else{
            return response()->json(["message"=>"Usuario no encontrado en la base de datos"], 404);
        }
        return response()->json(["message"=>"Usuario actualizado"], 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::find($id);
        if ($user){
            User::where('id', $id)->delete();
        }else{
            return response()->json(["message"=>"Usuario no encontrado en la base de datos"], 404);
        }
        return response()->json(["message"=>"Usuario eliminado"], 201);
    }
}




