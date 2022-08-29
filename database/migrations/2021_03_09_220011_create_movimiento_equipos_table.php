<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientoEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_equipos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_equipo');
            $table->integer('id_area');
            $table->integer('id_usuario');
            $table->string('registro', 200);
            $table->date('fecha');
            $table->string('comentarios');
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
        Schema::dropIfExists('movimiento_equipos');
    }
}
