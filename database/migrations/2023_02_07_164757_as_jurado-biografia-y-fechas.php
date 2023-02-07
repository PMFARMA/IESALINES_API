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
        Schema::table('as_jurado', function (Blueprint $table) {
            $table->string('biografia', 1000)->nullable();
            $table->DATETIME('created_at')->nullable();
            $table->DATETIME('updated_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        {
            Schema::table('as_jurado', function (Blueprint $table) {
                $table->dropColumn('biografia');
                $table->dropColumn('created_at');
                $table->dropColumn('updated_at');

            });
        }
    }
};
