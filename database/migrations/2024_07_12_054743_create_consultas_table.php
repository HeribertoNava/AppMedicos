<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');  // Añadir campo paciente_id
            $table->unsignedBigInteger('doctor_id');    // Añadir campo doctor_id
            $table->string('correo');
            $table->string('nombre');
            $table->text('motivo_consulta');
            $table->text('notas_padecimiento')->nullable();
            $table->text('interrogatorio_aparatos_sistemas')->nullable();
            $table->text('examen_fisico')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('plan')->nullable();
            $table->decimal('total_a_pagar', 8, 2);
            $table->timestamps();

            // Añadir relaciones de clave foránea
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
