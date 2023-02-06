<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tipos_jurado = ['Creatividad','Formacion', 'Salud'];
        $i = 0;
        foreach ($tipos_jurado as $key) {
            if ($i<3) {
                $id = $i+1;
                $nombre = $key;
                $data=array('id'=>$id,"nombre"=>$nombre);
                DB::table('tipojurado')->insert($data);
                $i++;
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipojurado');

        Schema::create('tipojurado', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
        });
    }
};
