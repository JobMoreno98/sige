<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('udg_id',50);
            $table->string('tipo_equipo', 200);
            $table->string('marca', 200);
            $table->string('modelo', 200);
            $table->string('numero_serie', 50);
            $table->string('mac', 20);
            $table->string('ip', 20);
            $table->string('tipo_conexion', 200);
            $table->string('detalles', 500);
            $table->integer('id_resguardante');
            $table->tinyInteger('activo');
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
        Schema::dropIfExists('equipos');
    }
}
