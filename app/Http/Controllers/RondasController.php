<?php

namespace App\Http\Controllers;
use App\Models\AuxTipoJuradoSubCat;
use App\Models\Subcategorias;
use App\Models\Edicion;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RondasController extends Controller
{
    public function juradoPorcentaje(){
        $creatividad_count=0;
        $formacion_count=0;
        $salud_count=0;
        $jurados = User::select('as_jurado.*', 'as_tipojurado.nombre AS categoria')->where('as_jurado.id_edicion','=','28')->join('as_tipojurado','as_jurado.id_tipojurado','=','as_tipojurado.id')->get();

        $total_sub_categorias = AuxTipoJuradoSubCat::select('*')->get();
        foreach ($total_sub_categorias as $index_subcategoria) {
            // dd($index_subcategoria->id_tipojurado);
            switch ($index_subcategoria->id_tipojurado) {
                case 1:
                    $creatividad_count = $creatividad_count +1;
                    break;

                case 2:
                    $formacion_count = $formacion_count + 1;
                    break;

                case 3:
                    $salud_count = $salud_count+1;
                    break;

            }
        }

        foreach ($jurados as $jurado) {
            $total_votacion = "";
        }
        // dd($creatividad_count);
        dd($jurados);

    }

    public function subCategoriaPorcentaje(){

    }
}
