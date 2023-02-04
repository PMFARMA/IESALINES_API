<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Edicion;
use Carbon\Carbon;
use Illuminate\Http\Request;


class JuradoController extends Controller
{
    /**
     * Devuelve todos los jurados de la edición actual.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anio = Carbon::now()->year;
        $id_edicion = Edicion::select('id')->where('anio', $anio - 1)->get();
        $item = User::select('id', 'Nombre', 'Empresa', 'Tipo_jurado', 'Email', 'nom_imagen', 'id_tipojurado')->where('id_edicion', $id_edicion[0]->id)->get();
        return  $item;
    }

/**////////////////////////////////////////////////////////////////////////////////////////////////// */
    public function create( Request $request)
    {

        //**no se si el id de edicion los buscamos con el año actual o enviarselo directamente */
        // $anio = Carbon::now()->year;
        // $id_edicion = Edicion::select('id')->where('anio', $anio - 1)->get();
        User::create([
            "email"=>$request->email,
            "id_tipojurado"=>$request->id_tipojurado,
            "id_edicion"=>$request->id_edicion,
            "nombre"=>$request->nombre,
            "cargo"=>$request->cargo,
            "empresa"=>$request->empresa
        ]);

        $user = User::select('id')
        ->where('email',$request->email)
        ->where('id_edicion',$request->id_edicion)->get();

        if(count($user)>0){
            return response()->json($user[0],201);
        }else{
            return response()->json(["message"=>"no se ha podido agregar al jurado"],201);
        };
    }

/**////////////////////////////////////////////////////////////////////////////////////////////////// */
    /**
     * Actualiza usuario a traves de id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->nombre = $request->nombre;
            $user->nom_imagen = $request->nom_imagen;
            $user->email = $request->email;
            $user->id_tipojurado = $request->id_tipojurado;
            $user->cargo = $request->cargo;
            $user->empresa = $request->empresa;
            $user->texto = $request->texto;
            $user->save();
        } else {
            return response()->json(["message" => "Usuario no encontrado en la base de datos"], 404);
        }
        return response()->json(["message" => "Usuario actualizado"], 201);
    }

/**////////////////////////////////////////////////////////////////////////////////////////////////// */

    public function getUserByEmail(Request $request)
    {

        $user = User::select('nombre', 'cargo', 'empresa', 'id_tipojurado', 'id_edicion')->where('email', $request->email)->get();

        if (count($user) > 0) {

            /**no se si mejor enviar la edicion via request */
            $anio = Carbon::now()->year;
            $id_edicion = Edicion::select('id')->where('anio', $anio - 2)->get();
            
            /**evitamos error humano (repetir jurado misma edición) */
            if ($user[count($user) - 1]->id_edicion != $id_edicion[0]->id) { 
                return response()->json($user[count($user) - 1], 201);
            } else {
                return response()->json(["message" => 'el usuario ya ha sido inscrito en esta edición'], 401);
            }
        } else {
            return response()->json(["message" => "Usuario no encontrado en la base de datos"], 404);
        }
    }

/**////////////////////////////////////////////////////////////////////////////////////////////////// */

    /**Busca usuario pos id */
    public function getUserById(Request $request)
    {

        $user = User::select('nombre_imagen', 'nombre', 'cargo', 'empresa', 'texto')->where('id', $request->id)->get();

        if (count($user)>0) {
            return response()->json($user, 201);
        } else {
            return response()->json(["message" => "Usuario no encontrado en la base de datos"], 404);
        }
    }

/**////////////////////////////////////////////////////////////////////////////////////////////////// */

    /**Actualización de los datos enviados a traves de la aceptación */
    public function confirmationUser(Request $request, $id)
    {

        $user = User::find($id);
        if ($user) {
            $user->nombre = $request->nombre;
            $user->nom_imagen = $request->nom_imagen;
            $user->cargo = $request->cargo;
            $user->empresa = $request->empresa;
            $user->texto = $request->texto;
            $user->aceptación = Carbon::now()->format('Y-m-d') . ' ' . Carbon::now()->format('H:i');
            $user->save();
        } else {
            return response()->json(["message" => "Usuario no encontrado en la base de datos"], 404);
        }
        return response()->json(["message" => "aceptacion realizada"], 201);
    }

/**////////////////////////////////////////////////////////////////////////////////////////////////// */
    /**
     * Elimina usuario por id.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            User::where('id', $id)->delete();
        } else {
            return response()->json(["message" => "Usuario no encontrado en la base de datos"], 404);
        }
        return response()->json(["message" => "Usuario eliminado"], 201);
    }
}
