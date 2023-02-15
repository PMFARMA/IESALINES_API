<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votaciones extends Model
{
    use HasFactory;
    protected $table = 'as_edicion_obras_voto_jurado';

    protected $fillable = [
        'id_cod_particip',
        'id_obra', 
        'id_jurado',	
        'voto'
    ];



}

/*id	
id_cod_particip	
id_obra	
id_jurado	
voto	 */