<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemBajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_baja', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',250);
            $table->year('ano_adquisicion');
            $table->string('motivo_baja');
            $table->date('fecha_revision');
            $table->string('encargado_revicion',150);
            $table->string('encargado_revicion_mantenimiento',150);
            $table->string('motivo_de_no_reparacion');
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
        Schema::dropIfExists('item_baja');
    }
}
