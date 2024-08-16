<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboracionesTable extends Migration
{
    public function up()
    {
        Schema::create('colaboraciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consulta_id');
            $table->unsignedBigInteger('medico_colaborador_id');
            $table->text('mensaje')->nullable();
            $table->timestamps();

            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade');
            $table->foreign('medico_colaborador_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('colaboraciones');
    }
}
