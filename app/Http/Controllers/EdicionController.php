<?php

namespace App\Http\Controllers;

use App\Models\Edicion;
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
       $data = Edicion::all();
       return $data;
    }
}
