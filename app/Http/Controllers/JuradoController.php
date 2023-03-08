<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Edicion;
use App\Models\EdicionObras;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;


class JuradoController extends Controller
{
    /**
     * Devuelve todos los jurados de la edición actual.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_edicion = Edicion::select('id')->where('estado', 0)->get();

        // return $id_edicion;
        if(count($id_edicion)==0){
            return response()->json(["message"=>'no hay edición creada para este año'],404);
        }

        $item = User::select('as_jurado.id','as_tipojurado.nombre AS tipo_jurado','id_tipojurado' ,'as_jurado.Nombre', 'Empresa','Email','nom_imagen','aceptacion','biografia','cargo')->join('as_tipojurado', 'as_jurado.id_tipojurado', '=', 'as_tipojurado.id')->where('as_jurado.id_edicion', $id_edicion[0]->id)->get();

        // $users = User::join('as_tipojurado', 'as_jurado.id', '=', 'as_tipojurado.id')->get(['as_jurado.id', 'as_jurado.nombre', 'as_tipojurado.nombre']);

        return  $item;
    }

/**////////////////////////////////////////////////////////////////////////////////////////////////// */
    public function create( Request $request)
    {
      
        $anio = Edicion::select('anio')->where('estado', 0)->get();

        $obrasIncompatibles = [];
        $obras = EdicionObras::selectRaw('id,YEAR(fecha_edicion)')->where('empresa_original',$request->empresa)->get();

        foreach($obras as $obra){
            
            if($obra['YEAR(fecha_edicion)']==$anio[0]->anio){
                array_push($obrasIncompatibles,$obra->id);
            }
            
        }

        User::create([
            "email"=>$request->email,
            "id_tipojurado"=>$request->id_tipojurado,
            "id_edicion"=>$request->id_edicion,
            "nombre"=>$request->nombre,
            "cargo"=>$request->cargo,
            "empresa"=>$request->empresa,
            "obra_incompatible"=>implode(',',$obrasIncompatibles)
        ]);

        $user = User::select('id')
        ->where('email',$request->email)
        ->where('id_edicion',$request->id_edicion)->get();

        if(count($user)>0){
            return response()->json($user[0],201);
        }else{
            return response()->json(["message"=>"no se ha podido agregar al jurado"],404);
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
            $user->biografia = $request->biografia;
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

            /**recogemos el id de la edicion de actual*/
            $id_edicion = Edicion::select('id')->where('estado', 0)->get();

            if(count($id_edicion)==0){
                return response()->json(["message"=>'no hay edición creada para este año'],404);
            }

            /**evitamos error humano (repetir jurado misma edición) */
            if ($user[count($user) - 1]->id_edicion != $id_edicion[0]->id) {
                return response()->json($user[count($user) - 1], 201);
            } else {
                return response()->json(["message" => 'el usuario ya ha sido inscrito en esta edición'], 401);
            }
        } else {
            return response()->json(["message" => "Usuario no encontrado en la base de datos"], 200);
        }
    }

/**////////////////////////////////////////////////////////////////////////////////////////////////// */

    /**Busca usuario por id */
    public function getUserById(Request $request)
    {
        $decrypt = Crypt::decryptString($request->id);

        $id = (int) $decrypt;

        $user = User::select('nom_imagen', 'nombre', 'cargo', 'empresa','biografia','obra_incompatible')->where('id',$id )->get();

        if (count($user)>0) {

            $user[0]->obra_incompatible = explode(',',$user[0]->obra_incompatible);

            return response()->json($user, 201);
        } else {
            return response()->json(["message" => "Usuario no encontrado en la base de datos"], 404);
        }
    }

/**////////////////////////////////////////////////////////////////////////////////////////////////// */

    /**Actualización de los datos enviados a traves de la aceptación */
    public function userConfirmation(Request $request, $user)
    {
        
        $decrypt = Crypt::decryptString($user);

        $id = (int) $decrypt;
        // return response()->json($id);
        $user = User::find($id);
        // return $user;
        if ($user) {
            $user->nombre = $request->nombre;
            $user->nom_imagen = $request->nom_imagen;
            $user->cargo = $request->cargo;
            $user->empresa = $request->empresa;
            $user->biografia = $request->biografia;
            $user->aceptacion = Carbon::now()->format('Y-m-d') . ' ' . Carbon::now()->format('H:i');
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




