<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    protected $table = 'as_edicion_cods_areas';

    protected $casts = [

     'id_edicion',
     'id'=>'string',
     'descrip',
     'descrip_dirigido',
     'leyenda' 	

    ];


}
