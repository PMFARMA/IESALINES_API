<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopUp extends Model
{
    use HasFactory;

    protected $table = 'AS_tipojurado';


    protected $fillable = [

        'id',
        'titulo',
        'subtitulo',
        'mensaje',
        'fecha_reunion',
        'ruta_video',
        'tipo_jurado',
        'id_edicion'

    ];
}
