<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obras extends Model
{
    use HasFactory;
    protected $table = 'as_edicion_obras';
    protected $fillable = ['id',
    'id_usuario', 
    'id_cod_particip', 
    'premio', 
    'premio_cod', 
    'empresa_original', 
    'recibida_ok', 
    'logs', 
    'publicar_en_archivo', 
    'titulo', 
    'descripcion', 
    'estrategia', 
    'plan_accion', 
    'cliente', 
    'contacto_cliente', 
    'contacto_cliente_email', 
    'producto', 
    'fecha_edicion', 
    'target_dirigido', 
    'dir_creativo', 
    ' dir_artistico', 
    'copy','
    dis_grafico', 
    'dis_multimedia', 
    'fotografo', 
    'ilustrador', 
    'productora', 
    'realizador', 
    'camara', 
    'musica', 
    'auditada', 
    'auditada_comments', 
    'equipo_cuenta', 
    'extra1', 
    'extra2', 
    'extra3','
    enviada_notificacion', 
    'recibido_pago', 
    'telfJurado', 'created_at', 'updated_at'];

}


