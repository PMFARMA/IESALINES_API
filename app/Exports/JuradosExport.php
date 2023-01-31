<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Edicion;
use Carbon\Carbon;

class JuradosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $anio = Carbon::now()->year;
        $id_edicion = Edicion::select('id')->where('anio', $anio-4)->get();
        $item = User::select('id', 'Nombre', 'Empresa', 'Tipo_jurado','Email','nom_imagen','id_tipojurado','id_edicion')->where('id_edicion', $id_edicion[0]->id)->get();
        return $item;
    }
}
