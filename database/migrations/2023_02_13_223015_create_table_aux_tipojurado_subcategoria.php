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
        Schema::create('as_aux_tipojurado_subcategoria', function (Blueprint $table) {
            $table->id();
            $table->integer('id_tipojurado');
            $table->integer('id_subcategoria');
            $table->integer('id_edicion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('as_aux_tipojurado_subcategoria');
    }
};
