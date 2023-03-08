<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Edicion;
use Carbon\Carbon;


class JuradosExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        $id_edicion = Edicion::select('id')->where('estado', 0)->get();

        
        if(count($id_edicion)==0){
           $item = [];
            return view('exportJurados',[
                'jurados' => $item
            ]);
        }

        $item = User::select('as_tipojurado.nombre AS Tipo_jurado', 'as_jurado.Nombre', 'Empresa', 'Email','aceptacion')->join('as_tipojurado', 'as_jurado.id_tipojurado', '=', 'as_tipojurado.id')->where('as_jurado.id_edicion', $id_edicion[0]->id)->get();

        
            return view('exportJurados',[
                'jurados' => $item
            ]);
        
       
        
    }

 
}
