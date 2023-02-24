<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategorias extends Model
{
    use HasFactory;

    protected $table = 'as_edicion_cods_particip';
    protected $fillable = [
        'id',
        'id_area',
        'id_edicion',
        'codigo',
        'descrip',
        'precio',
        'leyenda',
        'tiempo',
        'votacion_activa',
        'tipo_premio',
        'integralPartidoOro',
        'incompatibilidades'
    ];

}
