<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registro_lecturas', function (Blueprint $table) {
            $table->id();
            $table->string('almacen');
            $table->string('cliente');
            $table->string('lectura_inicial');
            $table->text('lectura_final');
            $table->string('imagen_lectura');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_lecturas');
    }
};
