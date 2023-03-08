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
        $edicion = Edicion::select('id','anio_romano','anio')->where('estado', 0)->get();

        return response()->json(["id"=>$edicion[0]->id,"anio_romano"=>$edicion[0]->anio_romano,"anio"=>$edicion[0]->anio]);
    }
}
