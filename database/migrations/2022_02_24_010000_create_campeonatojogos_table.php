<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampeonatoJogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campeonatoJogos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_campeonato');
            $table->unsignedBigInteger('id_time_casa');
            $table->unsignedBigInteger('id_time_fora');
            $table->integer('placar_time_casa')->nullable();
            $table->integer('placar_time_fora')->nullable();
            $table->string('fase')->nullable();
            $table->datetime('dt_cadastro')->useCurrent();
        });
        
        Schema::table('campeonatoJogos', function (Blueprint $table) {
            $table->foreign('id_campeonato')->references('id')->on('campeonatos')->onDelete('cascade');
            $table->foreign('id_time_casa')->references('id')->on('times')->onDelete('cascade');
            $table->foreign('id_time_fora')->references('id')->on('times')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campeonatoJogos');
    }
}
