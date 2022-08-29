<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumMascaraGetwayToIps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ips', function (Blueprint $table) {
            $table->text('mascara')
                    ->after('disponible')
                    ->nullable();

            $table->text('getaway')
                    ->after('disponible')
                    ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ips', function (Blueprint $table) {
            //
        });
    }
}
