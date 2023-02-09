<?php

namespace App\Http\Controllers;

use App\Models\Edicion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EdicionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $year = Carbon::now()->year;
       $edicion = Edicion::where('anio',$year)->get();

       if(count($edicion)==0){
        return response()->json(["message"=>'no hay edición creada para este año'],404);
    }
       return $edicion;
    }
}
