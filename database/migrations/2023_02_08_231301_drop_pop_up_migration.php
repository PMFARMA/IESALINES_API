<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::dropIfExists('as_popup');

        Schema::create('as_popup', function (Blueprint $table) {
            $table->id()->nullable();
            $table->string('tipo');
            $table->string('titulo')->nullable();
            $table->string('subtitulo')->nullable();
            $table->string('mensaje')->nullable();
            $table->string('fecha_reunion')->nullable();
            $table->string('ruta_video')->nullable();
            $table->integer('id_tipo_jurado');
            $table->integer('id_edicion');
            $table->timestamps();
            $table->index(['tipo','id_tipo_jurado','id_edicion']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('as_popup');
    }
};
