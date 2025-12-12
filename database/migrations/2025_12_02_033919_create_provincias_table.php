<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provincia', function (Blueprint $table) {
        $table->increments('id_provincia');
        $table->string('nombre_provincia', 100)->unique();
        $table->timestamps();
    });



    }

    public function down(): void
    {
        Schema::dropIfExists('provincia');
    }
};
