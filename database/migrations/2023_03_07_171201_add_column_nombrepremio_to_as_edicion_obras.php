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
        Schema::table('as_edicion_obras', function (Blueprint $table) {
            $table->string('nombre_premio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('as_edicion_obras', function (Blueprint $table) {
            $table->dropColumn('nombre_premio');
        });
    }
};
