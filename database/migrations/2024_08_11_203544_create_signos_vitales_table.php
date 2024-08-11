<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignosVitalesTable extends Migration
{
    public function up()
    {
        Schema::create('signos_vitales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained()->onDelete('cascade');
            $table->float('talla')->nullable(); // Talla en cm
            $table->float('temperatura')->nullable(); // Temperatura en °C
            $table->integer('frecuencia_cardiaca')->nullable(); // Frecuencia cardíaca en bpm
            $table->integer('saturacion_oxigeno')->nullable(); // Saturación de oxígeno en %
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('signos_vitales');
    }
}

