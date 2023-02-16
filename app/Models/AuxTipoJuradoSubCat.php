<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuxTipoJuradoSubCat extends Model
{
    use HasFactory;
    protected $table = 'as_aux_tipojurado_subcategoria';

    protected $fillable = [
        'id',
        'id_tipojurado',
        'id_subcategoria',
        'id_edicion'

    ];
}