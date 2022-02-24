<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampeonatoTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campeonatoTimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_campeonato');
            $table->unsignedBigInteger('id_time');
            $table->integer('pontuacao')->nullable();
            $table->datetime('dt_cadastro')->useCurrent();
        });
        
        Schema::table('campeonatoTimes', function (Blueprint $table) {
            $table->foreign('id_campeonato')->references('id')->on('campeonatos')->onDelete('cascade');
            $table->foreign('id_time')->references('id')->on('times')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campeonatoTimes');
    }
}
