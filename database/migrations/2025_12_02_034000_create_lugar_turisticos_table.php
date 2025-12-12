<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('lugar_turisticos', function (Blueprint $table) {
        $table->increments('id_lugar');
        $table->string('nombre_lugar', 200);
        $table->unsignedInteger('id_provincia');
        $table->unsignedInteger('id_tipo');
        $table->float('latitud');
        $table->float('longitud');
        $table->text('descripcion')->nullable();
        $table->string('anio_creacion', 10)->nullable();
        $table->string('accesibilidad', 50)->nullable();
        $table->timestamps();

        $table->foreign('id_provincia')->references('id_provincia')->on('provincia')->onDelete('cascade');
        $table->foreign('id_tipo')->references('id_tipo')->on('tipo_atraccions')->onDelete('cascade');
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('lugar_turisticos');
    }
};
