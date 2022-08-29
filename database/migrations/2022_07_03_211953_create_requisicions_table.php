<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisicionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicions', function (Blueprint $table) {
            $table->id();
            $table->integer('num_sol');
            $table->date('fecha');
            $table->string('user', 50);
            $table->string('proyecto', 50);
            $table->string('fondo', 50);
            $table->date('fecha_recibido');
            $table->string('quien_recibe', 300);
            $table->string('documento', 100);
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
        Schema::dropIfExists('requisicions');
    }
}
