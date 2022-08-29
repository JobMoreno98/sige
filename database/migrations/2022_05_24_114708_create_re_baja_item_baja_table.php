<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReBajaItemBajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_baja_item_baja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_baja')->nullable();
            $table->unsignedBigInteger('id_itemBaja')->nullable();
            $table->timestamps();

            //relacion
            $table->foreign('id_baja')->references('id')->on('bajas')->onDelete('set null');
            $table->foreign('id_itemBaja')->references('id')->on('item_baja')->onDelete('set null');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('re_baja_item_baja');
    }
}
