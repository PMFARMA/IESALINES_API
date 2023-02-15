<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoJurado extends Model
{
    use HasFactory;
    protected $table = 'AS_tipojurado';

    protected $fillable = [
        "id",
        "nombre",
        "ini_ronda1",
        "limit_ronda1",
        "ini_ronda2",
        "limit_ronda2",
        "id_edicion", 
        "aceptacion_ronda"
    ];
}
