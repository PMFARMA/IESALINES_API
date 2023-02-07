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
        Schema::table('tipojurado', function (Blueprint $table) {
            $table->DATETIME('ini_Ronda_1')->nullable();
            $table->DATETIME('limit_Ronda_1')->nullable();
            $table->DATETIME('ini_Ronda_2')->nullable();
            $table->DATETIME('limit_Ronda_2')->nullable();
            $table->string('categoria')->nullable();
            $table->integer('id_edicion')->nullable();
        });
        Schema::rename('tipojurado', 'as_tipojurado');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('as_', function (Blueprint $table) {
            $table->dropColumn('ini_Ronda_1');
            $table->dropColumn('limit_Ronda_1');
            $table->dropColumn('ini_Ronda_2');
            $table->dropColumn('limit_Ronda_2');
            $table->dropColumn('limit_Ronda_2');
            $table->dropColumn('categoria');
            $table->dropColumn('id_edicion');

        });
        Schema::rename('as_tipojurado', 'tipojurado');
    }
};
