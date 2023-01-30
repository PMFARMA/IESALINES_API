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
       $data = Edicion::where('anio',$year-1)->get();
       return $data;
    }
}
